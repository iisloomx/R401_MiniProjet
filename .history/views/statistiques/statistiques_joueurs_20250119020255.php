<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../views/header.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques des Joueurs</title>
    <link rel="stylesheet" href="../views/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Statistiques des Joueurs</h1>

        <!-- Formulaire de sélection du joueur -->
        <form action="StatistiquesController.php?action=joueurs" method="POST">
            <label for="numero_licence">Sélectionnez un joueur :</label>
            <select name="numero_licence" id="numero_licence" required>
                <option value="">-- Choisir un joueur --</option>
                <?php foreach ($joueurs as $joueur): ?>
                    <option value="<?= htmlspecialchars($joueur['numero_licence']) ?>" <?= isset($_POST['numero_licence']) && $_POST['numero_licence'] === $joueur['numero_licence'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($joueur['nom'] . ' ' . $joueur['prenom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Afficher les statistiques</button>
        </form>

        <!-- Affichage des statistiques du joueur sélectionné -->
        <?php if (!empty($selectedPlayerStats)): ?>
            <h2>Statistiques pour <?= htmlspecialchars($selectedPlayerStats['statut']['nom']) . ' ' . htmlspecialchars($selectedPlayerStats['statut']['prenom']) ?></h2>
            <ul>
                <li><strong>Statut Actuel :</strong> <?= htmlspecialchars($selectedPlayerStats['statut']['statut']) ?></li>
                <li><strong>Poste Préféré :</strong> <?= htmlspecialchars($selectedPlayerStats['poste_prefere']) ?></li>
                <li><strong>Nombre de Titularisations :</strong> <?= htmlspecialchars($selectedPlayerStats['titularisations']) ?></li>
                <li><strong>Nombre de Remplacements :</strong> <?= htmlspecialchars($selectedPlayerStats['remplacements']) ?></li>
                <li><strong>Moyenne des Évaluations :</strong> <?= number_format($selectedPlayerStats['moyenne_evaluations'], 2) ?></li>
                <li><strong>Pourcentage de Matchs Gagnés :</strong> <?= number_format($selectedPlayerStats['pourcentage_gagnes'], 2) ?>%</li>
                <li><strong>Nombre de Sélections Consécutives :</strong> <?= htmlspecialchars($selectedPlayerStats['selections_consecutives']) ?></li>
            </ul>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <p>Aucune statistique trouvée pour le joueur sélectionné.</p>
        <?php endif; ?>

        <!-- Bouton retour -->
        <div class="return-button">
            <a href="StatistiquesController.php?action=index" class="btn-stat">Retour aux Statistiques</a>
        </div>
    </div>
</body>
</html>
