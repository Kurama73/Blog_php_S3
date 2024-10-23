<?php
if ($_SESSION["isAdmin"]) {
    if (!isset($_SESSION["isConnected"]) || $_SESSION["isConnected"] == false) {

if (!(basename($_SERVER['PHP_SELF']) == "categorie.php")) {

    if (!isset($_SESSION["isConnected"]) || $_SESSION["isConnected"] == false) {

        header("Location: index.php");
        exit;
    }

    if (!isset($_SESSION["username"]) || empty($_SESSION["username"] )) {
        header("Location: choose-username.php");
        exit;
    }

} else {

    if (!isset($_SESSION["isConnected"]) || $_SESSION["isConnected"] == false) {

        header("Location: ../src/index.php");
        exit;
    }

    if (!isset($_SESSION["username"]) || empty($_SESSION["username"] )) {
        header("Location: ../src/choose-username.php");
        exit;
    }

}


?>