<?php
// Adding header
require_once('header.php');

// Destroying all previous session variables
session_unset();

// Initialization of exception variables
$ex_password = null;
$_SESSION["isConnected"] = false;
$_SESSION["isAdmin"] = false;
$_SESSION["pseudo"] = null;

if (!empty($_POST["in-email"]) && !empty($_POST["in-password"])) {
    if (str_contains($_POST["in-email"], "@")) {
        // Initializing session variables
        $_SESSION["email"] = $_POST["in-email"];
        $_SESSION["password"] = $_POST["in-password"];
        //$_SESSION["isAdmin"] = false;

        // Database recovery
        try {
            // Email and password query in database
            $stmt = $con->prepare("SELECT email, mdp FROM utilisateur");
            $res = $stmt->execute();

            // Comparison between input data and database
            foreach ($stmt as $row) {
                if ($row['email'] == $_SESSION["email"]) {
                    if ($row['mdp'] == $_SESSION["password"]) {

                        $stmt = $con->prepare("SELECT id_utilisateur,email, mdp, admin, pseudo FROM utilisateur WHERE email = ? AND mdp = ?");
                        $stmt->bindParam(1, $_SESSION["email"]);
                        $stmt->bindParam(2, $_SESSION["password"]);
                        $stmt->execute();
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);

                        // Initialization of session variables
                        $_SESSION["id"] = $user["id_utilisateur"];
                        $_SESSION["pseudo"] = $user["pseudo"];
                        $_SESSION["isConnected"] = true;

                        if ($user["admin"] == 1) {
                            $_SESSION["isAdmin"] = true;
                        }

                        header('Location: home.php');
                        exit();

                    } else {
                        $ex_password = "Password not recognized, please try again!";
                    }
                }
            }

            if ($ex_password == null) {
                header('Location: choose-pseudo.php');
                exit();
            }

        } catch (PDOException $e) {
            die('PDO error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('General error: ' . $e->getMessage());
        }

    } else {
        echo 'An email needs an "@"';
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
</head>

<body>

    <div class="form-container bg-woodsmoke-800 shadow-maroon-flush-300 shadow-md">
        <h1 class="text-3xl text-white">Login</h1>

        <form method="post" action="index.php">
            <input type="email" name="in-email" placeholder="E-mail" required
                class="text-white bg-woodsmoke-800 border">
            <input type="password" name="in-password" placeholder="Password" required
                class="text-white bg-woodsmoke-800 border">
            <input type="submit" name="sb-login" value="Log in"
                class="form-button text-white bg-maroon-flush-700 cursor-pointer border">
        </form>

        <p class="text-xs text-red-600"><?php echo $ex_password ?></p>

    </div>

</body>

</html>