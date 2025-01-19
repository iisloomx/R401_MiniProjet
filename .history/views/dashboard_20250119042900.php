<?php
session_start(); // Démarrez la session au début du fichier

if (!isset($_SESSION['utilisateur'])) {
    header("Location: connexion.php");
    exit();
}

include 'header.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="table-container">
        <div class="dashboard-container">
            <h1>Bienvenue sur le Tableau de Bord</h1>
            <?php if (isset($_SESSION['utilisateur'])) : ?>
                <p>Bonjour, <?= htmlspecialchars($_SESSION['utilisateur']); ?> ! Vous êtes connecté.</p>
            <?php else : ?>
                <p>Erreur : Utilisateur non connecté.</p>
            <?php endif; ?>

                
                    <li><a href="../controllers/JoueursController.php?action=liste">Gestion des Joueurs</a></li>
                    <li><a href="../controllers/MatchsController.php?action=liste">Gestion des Matchs</a></li>
                    <li><a href="../controllers/StatistiquesController.php?action=index class="btn btn-deco"">Statistiques</a></li> <!-- Nouveau bouton -->
                    <li><a href="../controllers/DeconnexionController.php" class="btn btn-deco">Déconnexion</a></li>
                
        </div>
    </div>
</body>

</html>

<?php include 'footer.php'; ?>