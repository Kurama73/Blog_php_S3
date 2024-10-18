

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

            <label>Catégorie (séparé par un espace)</label> <br>
            <input type="text" name="categorie" maxlength="25" required> <br>

            <input type="submit" value="Poster">

        </form>

        <form action="ajoutArticle.php" method="post">

            <input type="submit" value="Annuler">
        </form>


        <?php
            $_SESSION["isConnected"] = true;

            if (!isset($_SESSION["isConnected"]) || $_SESSION["isConnected"] == false) {
                
                echo "Vous devez être connecté pour accéder à cette page.";

                header("Location: pdo.php");
                exit;
            }

            session_start();
            require "pdo.php";

            $_SESSION["username"] = "UserSix";

            if (isset($_POST["titre"]) && !empty($_POST["titre"]) && isset($_POST["article"]) && !empty($_POST["article"]) && isset($_POST["categorie"]) && !empty($_POST["categorie"])) {
                if (strlen(isset($_POST["titre"])) > 100) {
                    echo "Le titre doit etre inférieur a 100 char";
                    exit;
                } else if (strlen(isset($_POST["article"])) > 280) {
                    echo "L'article doit faire moins de 280 char";
                }
                

                

                $tabCategorie = explode(" ",$_POST["categorie"]);

                $insertArticle = false;

                $lastArticleId = 0;

                foreach ($tabCategorie as $categorie) {
                    $existe = false;
                    $stmt = $dbh->prepare("SELECT nom FROM categorie WHERE nom = ?");
                    $stmt->bindParam(1, $categorie);
                    $stmt->execute();
                    
                    foreach ($stmt as $row) {
                        if ($row["nom"] == $categorie) {
                            $existe = true;
                        }
                    }

                    if (!$existe) {
                        //création
                        $stmt = $dbh->prepare("INSERT INTO categorie (nom) VALUES (?)");
                        $stmt->bindParam(1, $categorie);
                        $stmt->execute();

                    } 

                    $stmt = $dbh->prepare("SELECT id_categorie FROM categorie WHERE nom = ?");
                    $stmt->bindParam(1, $categorie);
                    $stmt->execute();
                    $idCategorie = $stmt->fetch(PDO::FETCH_ASSOC);

                    //insertion

                    if (!$insertArticle) {

                        //recuperation id_utilisateur
                        $stmt = $dbh->prepare("SELECT id_utilisateur FROM utilisateur WHERE pseudo = ?");
                        $stmt->bindParam(1, $_SESSION["username"]);
                        $stmt->execute();
                        $idUtilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

                        $stmt = $dbh->prepare("INSERT INTO article (titre,description,id_utilisateur) VALUES (?,?,?)");
                        $stmt->bindParam(1, $_POST["titre"]);
                        $stmt->bindParam(2, $_POST["article"]);
                        $stmt->bindParam(3, $idUtilisateur["id_utilisateur"]);
                        $stmt->execute();

                        $lastArticleId = $dbh->lastInsertId();
                        $insertArticle = true;
                    }

                    $stmt = $dbh->prepare("INSERT INTO reference (id_article, id_categorie) VALUES (?,?)");
                    $stmt->bindParam(1, $lastArticleId);
                    $stmt->bindParam(2, $idCategorie["id_categorie"]);
                    $stmt->execute();
                }

                header("Location: ajoutArticle.php");
                exit;
            
            }
            


        ?>




    </main>
</body>
</html>