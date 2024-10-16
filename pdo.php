<?php
    // Base de données
    try {
        // Connexion à la base de données
        $dbh = new PDO('mysql:host=localhost;dbname=blog_php', 'root', '');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('Erreur PDO: ' . $e->getMessage());
    } catch (Exception $e) {
        die('Erreur générale: ' . $e->getMessage());
    }
?>
