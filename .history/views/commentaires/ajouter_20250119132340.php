<?php 
<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['utilisateur'])) {
    header('Location: ../controllers/UtilisateurController.php?action=connexion');
    exit();
}
include '../views/header.php'; 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Commentaire</title>
    <link rel="stylesheet" href="../views/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter un Commentaire pour le Joueur</h1>

        <!-- Form to add the comment -->
        <form action="CommentaireController.php?action=ajouter_commentaire&numero_licence=<?= $_GET['numero_licence'] ?>" method="POST">
            <div>
                <label for="sujet_commentaire">Sujet du Commentaire</label>
                <input type="text" name="sujet_commentaire" id="sujet_commentaire" required>
            </div>

            <div>
                <label for="texte_commentaire">Texte du Commentaire</label>
                <textarea name="texte_commentaire" id="texte_commentaire" rows="4" required></textarea>
            </div>

            <div>
                <button type="submit">Ajouter Commentaire</button>
            </div>
        </form>

        <a href="../controllers/JoueursController.php?action=lister" class="button">Retour à la Liste des Joueurs</a>
    </div>
</body>
</html>
<?php include '../views/footer.php'; ?>

