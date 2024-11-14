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
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <title>Tableau de Bord</title>
</head>
<body>
    <h1>Bienvenue sur le Tableau de Bord</h1>
    <p>Bonjour, <?= htmlspecialchars($_SESSION['utilisateur']); ?> ! Vous êtes connecté.</p>

    <nav>
        <ul>
            <li><a href="../controllers/JoueursController.php?action=liste">Gestion des Joueurs</a></li>
            <li><a href="../controllers/MatchsController.php?action=liste">Gestion des Matchs</a></li>
            <li><a href="../controllers/DeconnexionController.php">Déconnexion</a></li>
        </ul>
    </nav>

    <p>Utilisez les liens ci-dessus pour gérer les joueurs, les matchs ou pour vous déconnecter.</p>
</body>
</html>
