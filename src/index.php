<?php
// Adding header
require_once('header.php');

// Destroying all previous session variables
session_unset();

// Initialization of exception variables
$ex_password = null;
$_SESSION["isConnected"] = false;

if (!empty($_POST["in-email"]) && !empty($_POST["in-password"])) {
    if (str_contains($_POST["in-email"], "@")) {
        // Initializing session variables
        $_SESSION["email"] = $_POST["in-email"];
        $_SESSION["password"] = $_POST["in-password"];
        $_SESSION["isAdmin"] = false;

        // Database recovery
        try {
            // Email and password query in database
            $stmt = $con->prepare("SELECT email, mdp FROM utilisateur");
            $res = $stmt->execute();

            // Comparison between input data and database
            foreach ($stmt as $row) {
                if ($row['email'] == $_SESSION["email"]) {
                    if ($row['mdp'] == $_SESSION["password"]) {

                        $stmt = $con->prepare("SELECT email, mdp, admin, pseudo FROM utilisateur WHERE email = ? AND mdp = ?");
                        $stmt->bindParam(1, $_SESSION["email"]);
                        $stmt->bindParam(2, $_SESSION["password"]);
                        $stmt->execute();
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        if ($user["admin"] == 1 && $user["pseudo"] == "Admin") {
                            $_SESSION["isAdmin"] = true;
                        }
 
                        $_SESSION["username"] = $user["pseudo"];

                        $_SESSION["isConnected"] = true;

                        header('Location: home.php');
                        exit();

                    } else {
                        $ex_password = "Password not recognized, please try again!";
                    }
                }
            }

            if ($ex_password == null) {
                header('Location: choose-username.php');
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
    header("Location: index.php");
    exit;
            
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

<div class="form-container">
    <h1 class="text-3xl">Login</h1>

    <form method="post" action="index.php">
        <input type="email" name="in-email" placeholder="E-mail" required>
        <input type="password" name="in-password" placeholder="Password" required>
        <input type="submit" name="sb-login" value="Log in" class="form-button">
    </form>

    <p><?php echo $ex_password ?></p>

</div>

</body>
</html>