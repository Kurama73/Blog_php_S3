<?php
// Adding header
require_once('header.php');

if (!isset($_SESSION["isConnected"]) || $_SESSION["isConnected"] == false) {

    header("Location: index.php");
    exit;
}


// Filtrage par pseudo
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
if ($filter) {
    $stmt = $con->prepare("
            SELECT article.*, COUNT(commentaire.id_commentaire) AS comment_count 
            FROM article 
            LEFT JOIN commentaire ON article.id_article = commentaire.id_article
            LEFT JOIN utilisateur ON article.id_utilisateur = utilisateur.id_utilisateur
            WHERE article.pseudo LIKE :filter 
            GROUP BY article.id_article 
            ORDER BY date DESC
        ");
    $stmt->bindValue(':filter', '%' . $filter . '%');
} else {
    $stmt = $con->prepare("
            SELECT article.*, COUNT(commentaire.id_commentaire) AS comment_count 
            FROM article 
            LEFT JOIN commentaire ON article.id_article = commentaire.id_article 
            GROUP BY article.id_article 
            ORDER BY date DESC
        ");
}

$stmt->execute();
$article = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
</head>
<body>
<main class="p-2">
    <div class="home-header items-center">
        <form method="get" class="col-start-2 text-center">
            <input type="text" name="filter" placeholder="Filter by username"
                   value="<?php echo htmlspecialchars($filter); ?>" class="w-4/6">
            <input type="submit" name="bt-filter" value="Filter">
        </form>

        <!-- Bouton créer un article -->
        <div class="create-article">
            <a href="ajoutArticle.php">Créer un article</a>
        </div>

        <?php

            if ($_SESSION["isAdmin"] == true) {
                echo '
                    <div class="CRUD">
                        <form action="crud.php" method="post">
                            <input type="submit" value="Acceder au CRUD">
                        </form>
                    </div>
                ';
                
            }  

        ?>

        
    </div>

    <!-- Article -->
    <div class="flex flex-col items-center w-full m-auto ">
        <?php foreach ($article as $row): ?>
            <a href="article.php?id=<?php echo $row['id_article']; ?>&filter=<?php echo urlencode($filter); ?>"
               class="article_link">
                <div class="">
                    <!--<h2><?php echo htmlspecialchars($row['pseudo']); ?> / <?php echo htmlspecialchars($row['date']); ?> / <?php echo htmlspecialchars($row['categorie']); ?></h2> -->
                    <h1><em><?php echo htmlspecialchars($row['titre']); ?></em></h1>
                    <p><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                    <h2><?php echo htmlspecialchars($row['comment_count']); ?> commentaire(s)</h2>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>
