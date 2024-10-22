<?php
session_start();
require_once('pdo.php');

if (!(basename($_SERVER['PHP_SELF']) == "index.php")) {
    require ('redirection.php');
}


if (isset($_POST['log-out'])) {

    $_SESSION["isConnected"] = false;
    header("Location: index.php");
    exit;
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Sans:ital,wght@0,100..800;1,100..800&display=swap"
          rel="stylesheet">
    <link href="output.css" rel="stylesheet">
</head>
<body class="font-ubuntu">

<header class="flex justify-between px-5 py-7 shadow-md bg-gray-400">
    <h1 class="text-2xl font-bold"><a href="home.php">Blog.kpf</a></h1>


    <form method="post">

        <input type="hidden" name="log-out"/>
        <input type="image" src="images/icons/gi_logout.svg" alt="logout">

    </form>
</header>

</body>
</html>
