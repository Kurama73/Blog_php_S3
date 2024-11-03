<?php
// Adding header
require_once('header.php');


if (isset($_POST["titre"]) && !empty($_POST["titre"]) && isset($_POST["article"]) && !empty($_POST["article"]) && isset($_POST["categorie"]) && !empty($_POST["categorie"])) {
    if (strlen(isset($_POST["titre"])) > 100) {
        echo "Le titre doit etre inférieur a 100 char";
        exit;
    } else if (strlen(isset($_POST["article"])) > 280) {
        echo "L'article doit faire moins de 280 char";
        exit;
    }

    //recuperation id_utilisateur
    $stmt = $con->prepare("SELECT id_utilisateur FROM utilisateur WHERE pseudo = ?");
    $stmt->bindParam(1, $_SESSION["pseudo"]);
    $stmt->execute();
    $idUtilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $con->prepare("INSERT INTO article (titre,description,id_utilisateur) VALUES (?,?,?)");
    $stmt->bindParam(1, $_POST["titre"]);
    $stmt->bindParam(2, $_POST["article"]);
    $stmt->bindParam(3, $idUtilisateur["id_utilisateur"]);
    $stmt->execute();

    $lastArticleId = $con->lastInsertId();

    //boucler pr les catégories
    foreach ($_POST["categorie"] as $idCategorie) {

        $stmt = $con->prepare("INSERT INTO reference (id_article, id_categorie) VALUES (?,?)");
        $stmt->bindParam(1, $lastArticleId);
        $stmt->bindParam(2, $idCategorie);
        $stmt->execute();

    }

    header("Location: home.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add article / Blog.kpf</title>
</head>

<body class="bg-woodsmoke-800 flex justify-center items-center min-h-screen">

    <main class="max-w-2xl m-auto px-4 my-8">

        <div class="article rounded-xl p-5">
            <form action="add-article.php" method="post" class="space-y-6">

                <!-- Title -->
                <label for="titre">
                    Title (100 char. max)
                    <input type="text" id="titre" name="titre" maxlength="100" required
                        class="text-field flex flex-col w-full mt-1">
                </label>

                <!-- Article -->
                <div>

                    <label for="article">Article (280 max char)</label>

                    <textarea type="text" id="article" name="article" maxlength="280" rows="10" style=resize:none
                        required
                        class="text-field flex flex-col w-full mt-1"></textarea>
                </div>


                <!-- Categories -->
                <div>

                    <label for="categorie">Choose 1 or more category</label>

                    <select multiple id="categorie" name="categorie[]" required
                        class="text-field flex flex-col w-full mt-1">

                        <?php
                        require "pdo.php";
                        $stmt = $con->prepare("SELECT id_categorie, nom FROM categorie");
                        $stmt->execute();
                        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($categories as $categorie) {
                            echo "<option value='" . $categorie["id_categorie"] . "'>" . $categorie["nom"] . "</option>";
                        }
                        ?>
                    </select>

                </div>

                <!-- Actions -->
                <div class="flex justify-between">

                    <a href="home.php"
                        class="confirm-button bg-opacity-0 bg-primary-100 hover:bg-opacity-10 font-bold w-1/6 mx-0 text-center">
                        Cancel
                    </a>

                    <input type="submit" value="Post"
                           class="confirm-button w-1/6 mx-0">

                </div>

            </form>
        </div>

        <?php require_once('footer.php'); ?>

    </main>


</body>

</html>