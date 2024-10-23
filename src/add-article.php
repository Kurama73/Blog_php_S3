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
        $stmt->bindParam(1, $_SESSION["username"]);
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
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Blog - add article</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <main class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl m-auto px-4 my-9 bg-gray-300">
        

        <form action="add-article.php" method="post" class="space-y-6">


            <div>

                <label for="titre" class="block text-gray-700 font-bold">Title (100 max char)</label>

                <input type="text" id="titre" name="titre" maxlength="100" required
                    class="mt-2 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>


            <div>

                <label for="article" class="block text-gray-700 font-bold">Article (280 max char)</label>

                <textarea type="text" id="article" name="article" maxlength="280" rows="10" style=overflow:scroll;resize:none required
                    class="mt-2 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>


            <div>


                <label for="categorie" class="block text-gray-700 font-bold">Choose 1 or more category</label>

            foreach ($categories as $categorie) {
                echo "<option value='" . $categorie["id_categorie"] . "'>" . $categorie["nom"] . "</option>";
            }

            
            ?>

                <select multiple id="categorie" name="categorie[]" required
                        class="mt-2 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

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

            <div class="flex justify-between">

                <input type="submit" value="Post"
                    class="bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">

                <a href="home.php" class="bg-gray-300 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400">
                    Cancel
                </a>

            </div>

        </form>

    </main>

    <?php require_once('footer.php'); ?>

    </body>
    </html>
</main>
</body>
</html>
