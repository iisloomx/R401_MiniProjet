<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../views/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques</title>
    <link rel="stylesheet" href="../views/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Statistiques</h1>

        <div class="stats-options">
            <h2>Choisissez une statistique :</h2>
            <div class="buttons">
                <a href="StatistiqueController.php?action=matchs" class="btn">Statistiques des Matchs</a>
                <a href="StatistiqueController.php?action=joueurs" class="btn">Statistiques des Joueurs</a>
                <a href="StatistiqueController.php?action=selection_joueur" class="btn">Sélections Consécutives d'un Joueur</a>
                <a href="StatistiqueController.php?action=joueur_global" class="btn">Vue Globale par Joueur</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php include '../views/footer.php'; ?>
