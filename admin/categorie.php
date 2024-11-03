<?php

require "../src/header.php";

if (!isset($_SESSION["isConnected"]) || $_SESSION["isConnected"] == false) {

    header("Location: ../src/index.php");
    exit;
}

if (!isset($_SESSION["pseudo"]) || empty($_SESSION["pseudo"])) {
    header("Location: ../src/choose-pseudo.php");
    exit;
}

if (!isset($_SESSION["isAdmin"]) || $_SESSION["isAdmin"] == false) {
    header("Location: ../src/home.php");
    exit;
}

// Ajouter une nouvelle catégorie
if (isset($_POST['add'])) {
    $name = $_POST['name'] ?? null; // Utilise null si 'name' n'existe pas
    if (!empty($name)) {
        $stmt = $con->prepare("INSERT INTO categorie (nom) VALUES (:name)");
        $stmt->execute(['name' => $name]);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Modifier une catégorie
if (isset($_POST['update']) && isset($_POST['name'])) {
    $id = $_POST['id_categorie'];
    $name = $_POST['name'];
    if (!empty($name)) {
        $stmt = $con->prepare("UPDATE categorie SET nom = :name WHERE id_categorie = :id");
        $stmt->execute(['name' => $name, 'id' => $id]);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
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
    <title>CRUD / Blog.kpf</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <main class="max-w-2xl m-auto px-4 flex flex-col">

        <!-- Title -->
        <div class="home-header flex justify-center my-9">
            <h2 class="text-2xl font-bold text-white">Categories</h2>
        </div>

        <!-- Add-Categories -->
        <form method="POST" class="mb-4 flex justify-center">
            <div class="flex items-center">
                <label type="text" name="lb-category" class="mr-2 text-white">Add a new category: </label>
                <input type="text" name="name" placeholder="Category name" required min="1" max="20"
                    class="text-field rounded-l-xl rounded-r-none">
                <button type="submit" name="add" class="text-field rounded-r-xl rounded-l-none border-l-0">Add</button>
            </div>
        </form>

        <!-- Table -->
        <table class="article rounded-xl my-5">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($categories as $categorie): ?>

                    <tr>
                        <td class="px-4 py-2 text-center"><?= htmlspecialchars($categorie['id_categorie']) ?></td>

                        <td class="px-4 py-2">
                            <form method="POST" class="inline">
                                <input type="hidden" name="id_categorie" value="<?= $categorie['id_categorie'] ?>">
                                <input type="text" name="name" value="<?= htmlspecialchars($categorie['nom']) ?>" required
                                    class="text-field">
                        </td>

                        <td class="px-4 w-1/2">
                            <div class="flex space-x-2">
                                <button type="submit" name="update"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-lg">Update</button>

                                <button type="submit" name="delete" class="bg-blue-500 text-white px-4 py-2 rounded-lg"
                                    onclick="return confirm('Are you sure to remove this category?');">Remove</button>

                                <button type="submit" name="view_articles"
                                    class="bg-blue-500 text-white px-4 rounded-lg">View Articles</button>
                            </div>
                            </form>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>




        <!-- Article list-->
        <?php if (!empty($article_list)): ?>
            <div class="home-header w-3/5 justify-center my-9 text-white">
                <h2 class="text-2xl font-bold flex justify-center">Articles in Selected Category</h2>
                <br>
                <table class="min-w-full bg-woodsmoke-800">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Title</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($article_list as $article): ?>
                            <tr>
                                <td class="px-4 py-2 text-center"><?= htmlspecialchars($article['id_article']) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($article['titre']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <?php require_once('../src/footer.php'); ?>

    </main>
</body>

</html>