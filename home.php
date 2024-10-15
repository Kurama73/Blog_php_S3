<p>Great. You are now logged in!</p>

<?php
require_once('header.php');

echo $_SESSION['email'];
echo $_SESSION['password'];
echo $_SESSION['username'];
?>