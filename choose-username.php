<!doctype html>
<html lang="fr">
<body>

<div style="display: block; text-align: center; margin: auto">
    <h1>Choose your username</h1>

    <form method="post" action="choose-username.php">
        <input type="text" name="in-username" placeholder="Monsieur Jaloux">
        <input type="submit" name="sb-login" value="Sign Up">
    </form>

    <style>
        form {
            display: flex;
            flex-direction: column;
            width: 200px;
            margin: auto
        }

        input {
            margin-bottom: 10px;
            padding: 5px;
        }
    </style>

</div>

</body>
</html>

