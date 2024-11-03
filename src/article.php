<?php
// Adding header
require_once('header.php');
require "redirection.php";

// Récupération de l'article via son ID
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

$stmt = $con->prepare("
        SELECT *, DATE_FORMAT(article.date_article, '%b %d, %Y') AS date_formatee
        FROM article
        LEFT JOIN utilisateur ON article.id_utilisateur = utilisateur.id_utilisateur
        LEFT JOIN reference ON article.id_article = reference.id_article
        LEFT JOIN categorie ON reference.id_categorie = categorie.id_categorie
        WHERE article.id_article = :id
;");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$article = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des commentaires
$stmtComments = $con->prepare("SELECT * FROM commentaire c 
    JOIN utilisateur u ON c.id_utilisateur = u.id_utilisateur
    WHERE c.id_article = :id
    ORDER BY c.date DESC");
$stmtComments->bindValue(':id', $id, PDO::PARAM_INT);
$stmtComments->execute();
$comments = $stmtComments->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST["delete-article"]) && isset($_POST["id_commentaire"])) {
    $stmtComments = $con->prepare("DELETE FROM commentaire WHERE id_commentaire = ?");
    $stmtComments->bindParam(1, $_POST["id_commentaire"]);
    $stmtComments->execute();

    header("Location: article.php?id=" . $id);
    exit;
}

// Insertion commentaire
if (!empty($_POST["comment"])) {
    $stmt = $con->prepare("INSERT INTO commentaire (contenu, id_article, id_utilisateur) VALUES (?, ?, ?)");
    $stmt->bindParam(1, $_POST["comment"]);
    $stmt->bindParam(2, $id);
    $stmt->bindParam(3, $_SESSION["id"]);
    $stmt->execute();

    header("Location: Article.php?id=" . $id);
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Article / Blog.kpf</title>
</head>

<body>
<main class="max-w-2xl m-auto my-8 px-4 relative">

    <!-- Return Button -->
    <a href="home.php"
       class="absolute left-0 top-0 mt-9 -ml-14 flex items-center justify-center w-10 h-10 bg-primary-100 bg-opacity-60 text-primary-950 rounded-full hover:scale-105 transition-transform duration-200">
        <span class="text-xl">&larr;</span>
    </a>

    <!-- Article -->
    <div class="article rounded-xl p-7 mb-5">
        <div class="text-xs mb-2">
            <p class="font-medium"><?php echo $article[0]['pseudo'] ?> / <?php echo $article[0]['date_formatee'] ?>
                / <?php echo $article[0]['nom'] ?></p>
        </div>

        <h1 class="article-title font-bold mb-1 break-words"><?php echo htmlspecialchars($article[0]['titre']); ?></h1>
        <p class="break-words overflow-hidden overflow-ellipsis"><?php echo nl2br(htmlspecialchars($article[0]['description'])); ?></p>
    </div>

        <!-- Add comment -->
    <div>
        <form method="POST" class="flex space-x-2 mb-5">

            <textarea name="comment" maxlength="280" rows="3" placeholder="Add a comment" class="text-field w-full border-0 border-l-2 rounded-none outline-0 resize-none"></textarea>

            <button type="submit" class="bg-blue-600 text-white rounded-lg px-3 hover:bg-blue-700">Send</button>
        </form>
    </div>

    <!-- Liste des commentaires -->
    <?php if (!empty($comments)): ?>
        <div class="article rounded-xl p-3">
            <h3 class="text-xl font-semibold text-white p-4 border-b border-gray-300">Comments</h3>

            <?php foreach ($comments as $index => $comment): ?>
                <div class="p-4 <?php echo ($index < count($comments) - 1) ? 'border-b border-gray-300' : ''; ?>">
                    <p class="text-sm text-gray-500 mb-1">
                        <?php echo htmlspecialchars($comment['pseudo']); ?>
                        / <?php echo htmlspecialchars($comment['date']); ?>
                    </p>
                    <p class="text-white mb-2"><?php echo nl2br(htmlspecialchars($comment['contenu'])); ?></p>

                    <?php if (strtolower($comment['pseudo']) == strtolower($_SESSION["pseudo"])): ?>
                        <form method="post" class="flex items-center mt-2">
                            <input type="hidden" name="id_commentaire"
                                   value="<?php echo $comment['id_commentaire']; ?>">
                            <button type="submit" name="delete-article"
                                    class="text-red-500 hover:text-red-700 flex items-center">
                                <img src="./images/icons/gi_delete.svg" alt="delete-icon" class="w-4 h-4 mr-1">Delete
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php require_once('footer.php'); ?>

</main>
</body>

</html>
