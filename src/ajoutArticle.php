

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="styleAjoutArticle.css">
</head>
<body>
    <main>
    

        <form action="ajoutArticle.php" method="post">



            <label>Titre (100 char max)</label> <br>
            <input type="text" name="titre" maxlength="100" required> <br>

            <label>Article (280char max)</label> <br>
            <input type="text" name="article" maxlength="280" required> <br>

            <label for="categorie">Choisissez une ou plusieurs catégorie</label><br>
            <select multiple id="categorie" name="categorie[]" required>

                <?php
                    
                    require "pdo.php";

                    $stmt = $con->prepare("SELECT id_categorie, nom FROM categorie");
                    $stmt->execute();
                    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($categories as $categorie) {
                        echo "<option value='".$categorie["id_categorie"]."'>".$categorie["nom"]."</option>";
                    }
                ?>

            </select> <br>

            <input type="submit" value="Poster">

        </form>

        <form action="home.php" method="post">

            <input type="submit" value="Annuler">
        </form>


        <?php
            $_SESSION["isConnected"] = true;

            $_SESSION["username"] = "UserSix";
            if (!isset($_SESSION["isConnected"]) || $_SESSION["isConnected"] == false) {

                header("Location: index.php");
                exit;
            }

            if (!isset($_SESSION["username"]) || empty($_SESSION["username"] )) {
                header("Location: choose-username.php");
                exit;
            }

            session_start();

            require "pdo.php";

            

            if (isset($_POST["titre"]) && !empty($_POST["titre"]) && isset($_POST["article"]) && !empty($_POST["article"]) && isset($_POST["categorie"]) && !empty($_POST["categorie"])) {
                if (strlen(isset($_POST["titre"])) > 100) {
                    echo "Le titre doit etre inférieur a 100 char";
                    exit;
                } else if (strlen(isset($_POST["article"])) > 280) {
                    echo "L'article doit faire moins de 280 char";
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

                header("Location: ajoutArticle.php");
                exit;
            
            }
            


        ?>




    </main>
</body>
</html>