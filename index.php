<?php
// Adding header
require_once('header.php');

// Destroying all previous session variables
session_destroy();

if (!empty($_POST["in-email"]) && !empty($_POST["in-password"])) {
    if (str_contains($_POST["in-email"], "@")) {
        // Initializing session variables
        $_SESSION["email"] = $_POST["in-email"];
        $_SESSION["password"] = $_POST["in-password"];

        // Database recovery
        try {
            // Email and password query in database
            $stmt = $con->prepare("SELECT email_utilisateur, mdp_utilisateur FROM utilisateur");
            $res = $stmt->execute();

            // Comparison between input data and database
            foreach ($stmt as $row) {
                if ($row['email_utilisateur'] == $_SESSION["email"]) {
                    if ($row['mdp_utilisateur'] == $_SESSION["password"]) {
                        header('Location: home.php');

                    } else {
                        echo 'Password not recognized, please try again';
                    }
                    exit();
                }
            }

            header('Location: choose-username.php');
            exit();

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
    <title>Blog</title>
</head>
<body>

<div style="display: block; width: 200px; text-align: center; margin: auto">
    <h1>Login</h1>

    <form method="post" action="index.php" style="display: flex; flex-direction: column;">
        <input type="email" name="in-email" placeholder="E-mail" required>
        <input type="password" name="in-password" placeholder="Password" required>
        <input type="submit" name="sb-login" value="Login">
    </form>

    <style>
        input {
            margin-bottom: 10px;
            padding: 5px;
        }
    </style>

</div>

</body>
</html>
