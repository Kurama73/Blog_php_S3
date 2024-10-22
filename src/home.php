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
$nb_row = $stmt->rowCount();
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

<div class="home-header flex justify-around items-center my-9">

    <?php if ($_SESSION["isAdmin"] == true): ?>
        <form action="../admin/categorie.php" method="post">
            <input type="submit" value="Access to CRUD" class="rounded-3xl">
        </form>
    <?php endif; ?>

    <form method="get" class="flex w-5/12">
        <p class="flex items-center bg-gray-50 pl-3 rounded-l-3xl">&#128269; </p>
        <input type="text" name="filter" placeholder="Filter by username"
               value="<?php echo htmlspecialchars($filter); ?>" class="w-full mr-1.5">
        <input type="submit" name="bt-filter" value="Filter" class="w-1/5 rounded-r-3xl">
    </form>

    <!-- Bouton créer un article -->
    <form action="ajoutArticle.php">
        <input type="submit" name="bt-create-article" value="Create an article" class="rounded-3xl">
    </form>

</div>

<main class="max-w-2xl m-auto">

    <!-- Article -->
    <div class="flex flex-col w-full m-auto">

        <?php foreach ($article as $row): ?>
            <?php
            if ($row == $article[0]) {
                $border_radius = "rounded-t-xl";
            } else if ($row == $article[$nb_row - 1]) {
                $border_radius = "rounded-b-xl";
            } else {
                $border_radius = "rounded-none";
            }
            ?>

            <a href="article.php?id=<?php echo $row['id_article']; ?>&filter=<?php echo urlencode($filter); ?>">
                <div class="w-full bg-gray-300 px-4 py-5 shadow-xl border-primary-400 border-b-2 hover:bg-gray-250 <?php echo $border_radius; ?>">

                    <!--<h2><?php echo htmlspecialchars($row['pseudo']); ?> / <?php echo htmlspecialchars($row['date']); ?> / <?php echo htmlspecialchars($row['categorie']); ?></h2> -->
                    <h1 class="font-bold"><?php echo htmlspecialchars($row['titre']); ?></h1>
                    <p><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                    <h2 class="text-md">&#128172;<?php echo htmlspecialchars($row['comment_count']); ?></h2>

                </div>
            </a>
        <?php endforeach; ?>

    </div>
</main>
</body>
</html>
