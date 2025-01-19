<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
} include '../views/header.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Statistiques</h1>

        <!-- Statistiques des matchs -->
        <section class="stats-section">
            <h2>Statistiques des matchs</h2>
            <p>Total de matchs : <?= $matchStats['total'] ?? 0 ?></p>
            <p>Victoires : <?= $matchStats['victoires'] ?? 0 ?></p>
            <p>Défaites : <?= $matchStats['defaites'] ?? 0 ?></p>
            <p>Nuls : <?= $matchStats['nuls'] ?? 0 ?></p>
        </section>

        <!-- Statistiques des joueurs -->
        <section class="stats-section">
            <h2>Statistiques des joueurs</h2>
            <?php if (!empty($playerStats)) : ?>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Numéro Licence</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Statut</th>
                            <th>Titularisations</th>
                            <th>Remplacements</th>
                            <th>Moyenne des Évaluations</th>
                            <th>Matchs Joués</th>
                            <th>Matchs Gagnés</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($playerStats as $player): ?>
                            <tr>
                                <td><?= htmlspecialchars($player['numero_licence']) ?></td>
                                <td><?= htmlspecialchars($player['nom']) ?></td>
                                <td><?= htmlspecialchars($player['prenom']) ?></td>
                                <td><?= htmlspecialchars($player['statut']) ?></td>
                                <td><?= $player['titularisations'] ?? 0 ?></td>
                                <td><?= $player['remplacements'] ?? 0 ?></td>
                                <td><?= round($player['moyenne_evaluations'], 2) ?></td>
                                <td><?= $player['matchs_joues'] ?? 0 ?></td>
                                <td><?= $player['matchs_gagnes'] ?? 0 ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p class="no-data">Aucune statistique disponible pour les joueurs.</p>
            <?php endif; ?>
        </section>

        <!-- Bouton de retour -->
        <p>
            <a href="../views/dashboard.php" class="btn btn-back">Retour au dashboard</a>
        </p>
    </div>
</body>
</html>
<?php include '../views/footer.php'; ?>
