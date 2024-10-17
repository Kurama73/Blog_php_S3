<?php
// Adding header
require_once('header.php');


if (!empty($_POST["in-username"])) {
    // Initializing session variable
    $_SESSION["username"] = strtolower($_POST["in-username"]);

    try {
        // Adding the new user in the database
        $stmt = $con->prepare("INSERT INTO UTILISATEUR (email, mdp, pseudo, admin) VALUES (?, ?, ?, ?);");
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $mdp);
        $stmt->bindParam(3, $pseudo);
        $stmt->bindParam(4, $admin);

        $email = $_SESSION["email"];
        $mdp = $_SESSION["password"];
        $pseudo = $_SESSION["username"];
        $admin = 0;

        $stmt->execute();

    } catch (PDOException $e) {
        die('PDO error: ' . $e->getMessage());
    } catch (Exception $e) {
        die('General error: ' . $e->getMessage());
    }

    header('Location: home.php');
}
?>

<!doctype html>
<html lang="fr">
<body>

<div style="display: block; text-align: center; margin: auto">
    <h1>Choose your username</h1>

    <form method="post" action="choose-username.php">
        <input type="text" name="in-username" placeholder="Monsieur Jaloux" required>
        <input type="submit" name="sb-login" value="Sign Up">
    </form>

    <style>
        form {
            display: flex;
            flex-direction: column;
            width: 200px;
            margin: auto
        }

        input {
            margin-bottom: 10px;
            padding: 5px;
        }
    </style>

</div>

</body>
</html>

