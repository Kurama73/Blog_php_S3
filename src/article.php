<?php
// Adding header
require_once('header.php');
require "redirection.php";

// Récupération de l'article via son ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
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
<html lang="">
<head>
    <title><?php echo htmlspecialchars($article['titre']); ?></title>
</head>
<body>
<main class="max-w-2xl m-auto px-4">
    <!-- Bouton de retour -->
    <a href="home.php" class="return-button">
        <div class="circle">
            <span class="arrow">&larr;</span>
        </div>
    </a>

    <!-- Article -->
    <div class="rounded-xl shadow-lg w-full max-w-2xl m-auto px-4 py-5 my-9 bg-gray-300">
        <div class="text-xs mb-2">
            <p><?php echo htmlspecialchars($article[0]['pseudo']); ?>
                / <?php echo htmlspecialchars($article[0]['date_formatee']); ?></p>
        </div>
        <h1 class="font-bold mb-1"><?php echo htmlspecialchars($article[0]['titre']); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($article[0]['description'])); ?></p>
    </div>

    <div>
        <!-- Ajout commentaire -->
        <div>
            <form method="POST" class="flex">

                    <textarea name="comment" maxlength="280" rows="1" placeholder="Add a comment"
                              class="w-full resize-none px-4 py-3 rounded-sm"></textarea>

                <input type="submit" value="Send" class="bg-blue-600 rounded-lg ml-1 px-4 text-white">
            </form>
        </div>

        <hr class="my-10 border-2">

        <!-- Liste des commentaires -->
        <div>
            <h3>Comments</h3>
            <?php foreach ($comments as $comment): ?>
                <div>

                    <p class="text-xs mb-2"><?php echo htmlspecialchars($comment['pseudo']); ?>
                        / <?php echo htmlspecialchars($comment['date']); ?></p>

                    <p><?php echo nl2br(htmlspecialchars($comment['contenu'])); ?></p>

                    <?php
                    if (strtolower($comment['pseudo']) == strtolower($_SESSION["pseudo"])): ?>

                        <form method="post">

                            <input type="hidden" name="id_commentaire"
                                   value="<?php echo $comment['id_commentaire']; ?>">
                            <button type="submit" name="delete-article"><img src="./images/icons/gi_delete.svg"
                                                                             alt="delete-icon"></button>

                        </form>

                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
        </div>

    </div>

</main>
</body>
</html>
