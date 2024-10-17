<?php
// Adding header
require_once('header.php');

// Récupération de l'article via son ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

$stmt = $con->prepare("
        SELECT * FROM article
        LEFT JOIN utilisateur ON article.id_utilisateur = utilisateur.id_utilisateur
        LEFT JOIN reference ON article.id_article = reference.id_article
        LEFT JOIN categorie ON reference.id_categorie = categorie.id_categorie
        WHERE article.id_article = :id
;");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$article = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des commentaires
$stmtComments = $con->prepare("SELECT * FROM commentaire WHERE id_commentaire = :id ORDER BY date DESC");
$stmtComments->bindValue(':id', $id, PDO::PARAM_INT);
$stmtComments->execute();
$comments = $stmtComments->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['titre']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container">

    <!-- Bouton de retour -->
    <a href="home.php" class="return-button">
        <div class="circle">
            <span class="arrow">&larr;</span>
        </div>
    </a>

    <!-- Article -->
    <div class="article-block">
        <h2 class="text-xl"><?php echo htmlspecialchars($article[0]['pseudo']); ?> / <?php echo htmlspecialchars($article[0]['date']); ?>
            / <?php echo htmlspecialchars($article[0]['nom']); ?></h2>
        <h1 class="text-2xl"><?php echo htmlspecialchars($article[0]['titre']); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($article[0]['description'])); ?></p>
    </div>

    <!-- Ajout commentaire -->
    <div class="add-comment-block">
        <h3>Ajouter un commentaire</h3>
        <form method="POST" action="add_comment.php">
            <input type="hidden" name="id_article" value="<?php echo $article[0]['id_article']; ?>">
            <textarea name="comment" rows="4" placeholder="Your comment"></textarea>
            <input type="submit" value="Send">
        </form>
    </div>

    <!-- Liste des commentaires -->
    <div class="comments-block">
        <h3>Commentaire(s)</h3>
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <?php echo htmlspecialchars($comment['pseudo']); ?> / <?php echo htmlspecialchars($comment['date']); ?>
                <p><?php echo nl2br(htmlspecialchars($comment['contenu'])); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>
