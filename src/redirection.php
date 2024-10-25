<?php
if (!(basename($_SERVER['PHP_SELF']) == "categorie.php")) {

    if (!isset($_SESSION["isConnected"]) || $_SESSION["isConnected"] == false) {

        header("Location: index.php");
        exit;
    }

    if (!isset($_SESSION["pseudo"]) || empty($_SESSION["pseudo"] )) {
        header("Location: choose-pseudo.php");
        exit;
    }

} else {

    if (!isset($_SESSION["isConnected"]) || $_SESSION["isConnected"] == false && !(basename($_SERVER['PHP_SELF']) == "choose-pseudo.php")) {

        header("Location: ../src/index.php");
        exit;
    }

    if (!isset($_SESSION["pseudo"]) || empty($_SESSION["pseudo"] )) {
        header("Location: ../src/choose-pseudo.php");
        exit;
    }

}
    
?>