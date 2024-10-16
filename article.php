<?php
    session_start();
    require 'pdo.php';

    // Récupération de l'article via son ID
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    $filter = isset($_GET['filter']) ? $_GET['filter'] : '';

    $stmt = $dbh->prepare("SELECT * FROM articles WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    // Récupération des commentaires
    $stmtComments = $dbh->prepare("SELECT * FROM commentaires WHERE id_article = :id ORDER BY date DESC");
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
    <link rel="stylesheet" href="Style.css">
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
            <h2><?php echo htmlspecialchars($article['pseudo']); ?> / <?php echo htmlspecialchars($article['date']); ?> / <?php echo htmlspecialchars($article['categorie']); ?></h2>
            <h1><?php echo htmlspecialchars($article['titre']); ?></h1>
            <p><?php echo nl2br(htmlspecialchars($article['description'])); ?></p>
        </div>

        <!-- Ajout commentaire -->
        <div class="add-comment-block">
            <h3>Ajouter un commentaire</h3>
            <form method="POST" action="add_comment.php">
                <input type="hidden" name="id_article" value="<?php echo $article['id']; ?>">
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
