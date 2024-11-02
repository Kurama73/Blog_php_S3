<?php
// Adding header
require_once('header.php');


if (!empty($_POST["in-pseudo"])) {
    // Initializing session variable
    $_SESSION["pseudo"] = strtolower($_POST["in-pseudo"]);

    try {
        // Adding the new user in the database
        $stmt = $con->prepare("INSERT INTO utilisateur (email, mdp, pseudo, admin) VALUES (?, ?, ?, ?);");
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $mdp);
        $stmt->bindParam(3, $pseudo);
        $stmt->bindParam(4, $admin);

        $email = $_SESSION["email"];
        $mdp = $_SESSION["password"];
        $pseudo = $_SESSION["pseudo"];
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

    <div class="form-container bg-woodsmoke-800 shadow-maroon-flush-300 shadow-md">
        <h1 class="text-2xl text-white">Choose your pseudo</h1>

        <form method="post" action="choose-pseudo.php">
            <input type="text" name="in-pseudo" placeholder="Monsieur Jaloux" required
                class="text-white bg-woodsmoke-800 border">
            <input type="submit" name="sb-login" value="Sign Up"
                class="form-button text-white bg-maroon-flush-700 cursor-pointer border">
        </form>

    </div>

</body>

</html>