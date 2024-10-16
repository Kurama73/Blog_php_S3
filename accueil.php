<?php
    session_start();
    session_unset();

    require 'pdo.php';

    // Filtrage par pseudo
    $filter = isset($_POST['filter']) ? $_POST['filter'] : '';
    if ($filter) {
        $stmt = $dbh->prepare("
            SELECT articles.*, COUNT(commentaires.id) AS comment_count 
            FROM articles 
            LEFT JOIN commentaires ON articles.id = commentaires.id_article 
            WHERE articles.pseudo LIKE :filter 
            GROUP BY articles.id 
            ORDER BY date DESC
        ");
        $stmt->bindValue(':filter', '%' . $filter . '%');
    } else {
        $stmt = $dbh->prepare("
            SELECT articles.*, COUNT(commentaires.id) AS comment_count 
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <div class="header">
            <!-- Filtre -->
            <div class="filter">
                <form method="POST">
                    <input type="text" name="filter" id="filter" placeholder="Filter by username" value="<?php echo htmlspecialchars($filter); ?>">
                    <input type="submit" value="Filter">
                </form>
            </div>

            <!-- Bouton créer un article -->
            <div class="create-article">
                <a href="create_article.php">Créer un article</a>
            </div>
        </div>

        <!-- Articles -->
        <div class="articles">
            <?php foreach ($articles as $article): ?>
            <a href="article.php?id=<?php echo $article['id']; ?>&filter=<?php echo urlencode($filter); ?>" class="article_link">
                <div class="article">
                    <h2><?php echo htmlspecialchars($article['pseudo']); ?> / <?php echo htmlspecialchars($article['date']); ?> / <?php echo htmlspecialchars($article['categorie']); ?></h2>
                    <h1><em><?php echo htmlspecialchars($article['titre']); ?></em></h1>
                    <p><?php echo nl2br(htmlspecialchars($article['description'])); ?></p>
                    <h2><?php echo htmlspecialchars($article['comment_count']); ?> commentaire(s)</h2>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
