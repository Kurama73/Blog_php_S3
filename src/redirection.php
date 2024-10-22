<?php

if (!isset($_SESSION["isConnected"]) || $_SESSION["isConnected"] == false) {

    header("Location: index.php");
    exit;
}

if (!isset($_SESSION["username"]) || empty($_SESSION["username"] )) {
    header("Location: choose-username.php");
    exit;
}


?>