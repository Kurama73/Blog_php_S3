<?php
$con = null;
try {
    // Database connection
    $con = new PDO('mysql:host=localhost;dbname=blog_php', 'root', '');
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('PDO error: ' . $e->getMessage());
} catch (Exception $e) {
    die('General error: ' . $e->getMessage());
}
