<?php
    session_start();
    session_unset();

    require 'pdo.php';

    // Filtrage par pseudo si nécessaire
    $filtre = isset($_POST['filtre']) ? $_POST['filtre'] : '';
    if ($filtre) {
        $stmt = $dbh->prepare("
            SELECT articles.*, COUNT(commentaires.id) AS nb_commentaires 
            FROM articles 
            LEFT JOIN commentaires ON articles.id = commentaires.id_article 
            WHERE articles.pseudo LIKE :filtre 
            GROUP BY articles.id 
            ORDER BY date DESC
        ");
        $stmt->bindValue(':filtre', '%' . $filtre . '%');
    } else {
        $stmt = $dbh->prepare("
            SELECT articles.*, COUNT(commentaires.id) AS nb_commentaires 
            FROM articles 
            LEFT JOIN commentaires ON articles.id = commentaires.id_article 
            GROUP BY articles.id 
            ORDER BY date DESC
        ");
    }
    
    $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <!-- Barre de recherche -->
        <div class="filtre">
            <form method="POST">
                <input type="text" name="filtre" id="filtre" placeholder="Filtrer par pseudo" value="<?php echo htmlspecialchars($filtre); ?>">
                <input type="submit" value="Filtrer">
            </form>
        </div>

        <!-- Articles -->
        <div class="articles">
            <?php foreach ($articles as $article): ?>
            <a href="article.php?id=<?php echo $article['id']; ?>&filtre=<?php echo urlencode($filtre); ?>" class="article_lien">
                <div class="article">
                    <h2><?php echo htmlspecialchars($article['pseudo']); ?> / <?php echo htmlspecialchars($article['date']); ?> / <?php echo htmlspecialchars($article['categorie']); ?></h2>
                    <h1><em><?php echo htmlspecialchars($article['titre']); ?></em></h1>
                    <p><?php echo nl2br(htmlspecialchars($article['description'])); ?></p>
                    <h2><?php echo htmlspecialchars($article['nb_commentaires']); ?> commentaire(s)</h2>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Bouton créer un article -->
        <div class="creer-article">
            <a href="creer_article.php">Créer un article</a>
        </div>
    </main>
</body>
</html>
