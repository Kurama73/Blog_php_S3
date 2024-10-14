<?php 
    session_start(); 
    session_unset();

    require 'pdo.php';
    
    // Récupération des données depuis la BD
    $stmt = $dbh->prepare("SELECT * FROM partie");
    $stmt->execute();
    $parties = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu du Pendu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
    


    </main>
</body>
</html>