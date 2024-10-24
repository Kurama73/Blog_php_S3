<?php

require "../src/header.php";

if (!isset($_SESSION["isConnected"]) || $_SESSION["isConnected"] == false) {

    header("Location: ../src/index.php");
    exit;
}

if (!isset($_SESSION["username"]) || empty($_SESSION["username"] )) {
    
    header("Location: ../src/choose-username.php");
    exit;
}

if (!isset($_SESSION["isAdmin"]) || $_SESSION["isAdmin"] == false) {
    header("Location: ../src/home.php");
    exit;
}

// Ajouter une nouvelle catégorie
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    if (!empty($name)) {
        $stmt = $con->prepare("INSERT INTO categorie(nom) VALUES (:name)");
        $stmt->execute(['name' => $name]);
        header("Location: " . $_SERVER['PHP_SELF']);
    }
}

// Modifier une catégorie
if (isset($_POST['update'])) {
    $id = $_POST['id_categorie'];
    $name = $_POST['name'];
    if (!empty($name)) {
        $stmt = $con->prepare("UPDATE categorie SET nom = :name WHERE id_categorie = :id");
        $stmt->execute(['name' => $name, 'id' => $id]);
        header("Location: " . $_SERVER['PHP_SELF']);
    }
}

// Supprimer une catégorie
if (isset($_POST['delete'])) {
    $id = $_POST['id_categorie'];
    $stmt = $con->prepare("DELETE FROM categorie WHERE id_categorie = :id");
    $stmt->execute(['id' => $id]);
    header("Location: " . $_SERVER['PHP_SELF']);
}

// Récupérer toutes les catégories
$stmt = $con->query("SELECT * FROM categorie");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les articles d'une catégorie sélectionnée
$article_list = [];
if (isset($_POST['view_articles'])) {
    $categorie_id = $_POST['id_categorie'];
    $stmt = $con->prepare("SELECT * FROM article a 
                           JOIN reference r ON a.id_article = r.id_article 
                           WHERE r.id_categorie = :categorie_id");
    $stmt->execute(['categorie_id' => $categorie_id]);
    $article_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
</head>
<body>

<h2 style="text-align: center;">Categories</h2>

<form method="POST">
    <input type="text" name="name" placeholder="Categorie name" required>
    <button type="submit" name="add">Add</button>
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th colspan="3">Actions</th>
    </tr>
    <?php foreach ($categories as $categorie): ?>
    <tr>
        <td><?= htmlspecialchars($categorie['id_categorie']) ?></td>
        <td>
            <!-- modification -->
            <form style="display:inline;" method="POST">
                <input type="hidden" name="id_categorie" value="<?= $categorie['id_categorie'] ?>">
                <input type="text" name="name" value="<?= htmlspecialchars($categorie['nom']) ?>" required>
                <button type="submit" name="update">Update</button>
            </form>
            
            <!-- suppression -->
            <form style="display:inline;" method="POST" onsubmit="return confirm('Are you sure to remove this categorie ?');">
                <input type="hidden" name="id_categorie" value="<?= $categorie['id_categorie'] ?>">
                <button type="submit" name="delete">Remove</button>
            </form>
        </td>
        <td>
            <!-- view articles -->
            <form style="display:inline;" method="POST">
                <input type="hidden" name="id_categorie" value="<?= $categorie['id_categorie'] ?>">
                <button type="submit" name="view_articles">View Articles</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php if (!empty($article_list)): ?>
<h2>Articles in Selected Category</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Title</th>
    </tr>
    <?php foreach ($article_list as $article): ?>
    <tr>
        <td><?= htmlspecialchars($article['id_article']) ?></td>
        <td><?= htmlspecialchars($article['titre']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>

</body>
</html>
