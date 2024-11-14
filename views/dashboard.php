<?php include 'header.php'; ?>

<?php
session_start();
if (!isset($_SESSION['utilisateur'])) {
    header("Location: connexion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Bienvenue sur le Tableau de Bord</h1>
        <?php if (isset($_SESSION['utilisateur'])) : ?>
            <p>Bonjour, <?= htmlspecialchars($_SESSION['utilisateur']); ?> ! Vous êtes connecté.</p>
        <?php else : ?>
            <p>Erreur : Utilisateur non connecté.</p>
        <?php endif; ?>

        <nav>
            <ul>
                <li><a href="../controllers/JoueursController.php?action=liste">Gestion des Joueurs</a></li>
                <li><a href="../controllers/MatchsController.php?action=liste">Gestion des Matchs</a></li>
                <li><a href="../controllers/DeconnexionController.php">Déconnexion</a></li>
            </ul>
        </nav>

        <p>Utilisez les liens ci-dessus pour gérer les joueurs, les matchs ou pour vous déconnecter.</p>
    </div>
</body>
</html>

<?php include 'footer.php'; ?>
