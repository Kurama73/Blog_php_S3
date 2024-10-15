<?php
    session_start();
    require 'pdo.php';

    // Récupération de l'article via son ID
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    $filtre = isset($_GET['filtre']) ? $_GET['filtre'] : '';
    $scrollPos = isset($_GET['scrollPos']) ? $_GET['scrollPos'] : 0;

    $stmt = $dbh->prepare("SELECT * FROM articles WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    // Récupération des commentaires
    $stmtComments = $dbh->prepare("SELECT * FROM commentaires WHERE id_article = :id ORDER BY date DESC");
    $stmtComments->bindValue(':id', $id, PDO::PARAM_INT);
    $stmtComments->execute();
    $commentaires = $stmtComments->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['titre']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="container">

        <!-- Bouton de retour -->
        <a href="accueil.php?filtre=<?php echo urlencode($filtre); ?>&scrollPos=<?php echo $scrollPos; ?>" class="back-button">
            <div class="circle">
                <span class="arrow">&larr;</span>
            </div>
        </a>

        <!-- Article -->
        <div class="article-block">
            <h2><?php echo htmlspecialchars($article['pseudo']); ?> / <?php echo htmlspecialchars($article['date']); ?> / <?php echo htmlspecialchars($article['categorie']); ?></h2>
            <h1><?php echo htmlspecialchars($article['titre']); ?></h1>
            <p><?php echo nl2br(htmlspecialchars($article['description'])); ?></p>
        </div>

        <!-- Ajout commentaire -->
        <div class="ajouter-commentaire-block">
            <h3>Ajouter un commentaire</h3>
            <form method="POST" action="ajouter_commentaire.php">
                <input type="hidden" name="id_article" value="<?php echo $article['id']; ?>">
                <textarea name="commentaire" rows="4" placeholder="Votre commentaire"></textarea>
                <input type="submit" value="Envoyer">
            </form>
        </div>

        <!-- Liste des commentaires -->
        <div class="commentaires-block">
            <h3>Commentaires</h3>
            <?php foreach ($commentaires as $commentaire): ?>
                <div class="commentaire-item">
                    <strong><?php echo htmlspecialchars($commentaire['pseudo']); ?> / <?php echo htmlspecialchars($commentaire['date']); ?></strong>
                    <p><?php echo nl2br(htmlspecialchars($commentaire['contenu'])); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script>
        // Sauvegarder la position de scroll avant de quitter la page
        document.querySelector('.back-button').addEventListener('click', function() {
            let scrollPosition = window.scrollY;
            this.href += '&scrollPos=' + scrollPosition;
        });
    </script>
</body>
</html>
