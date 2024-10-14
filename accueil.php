<?php
    session_start();
    session_unset();

    require 'pdo.php';

    /*
    // Récupération des données depuis la BD
    $stmt = $dbh->prepare("SELECT * FROM articles ORDER BY date DESC");
    $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    */
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <form method="POST">
            <input type="text" name="filtre" id="filtre" placeholder="Filtrer par pseudo">
            <input type="submit" value="Filtrer">
        </form>

        <?php foreach ($articles as $article): ?>
        <div class="article">
            <h2><?php echo htmlspecialchars($article['pseudo']); ?> / <?php echo htmlspecialchars($article['date']); ?> / <?php echo htmlspecialchars($article['categorie']); ?></h2>
            <h1><em><?php echo htmlspecialchars($article['titre']); ?></em></h1>
            <p><?php echo nl2br(htmlspecialchars($article['description'])); ?></p>
            <h2><?php echo htmlspecialchars($article['commentaires']); ?> commentaire(s)</h2>
        </div>
        <?php endforeach; ?>

    </main>
</body>
</html>
