<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
} include '../views/header.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Match</title>
    <link rel="stylesheet" href="../views/css/style.css">
</head>
<body>
    <div class="match-details">
        <h1>Détails du Match</h1>

        <!-- Affichage des informations du match -->
        <?php if (isset($match)): ?>
            <p><strong>Date :</strong> <?= htmlspecialchars($match['date_match']); ?></p>
            <p><strong>Heure :</strong> <?= htmlspecialchars($match['heure_match']); ?></p>
            <p><strong>Équipe Adverse :</strong> <?= htmlspecialchars($match['nom_equipe_adverse']); ?></p>
            <p><strong>Lieu :</strong> <?= htmlspecialchars($match['lieu_de_rencontre']); ?></p>
            <p><strong>Résultat :</strong> <?= htmlspecialchars($match['resultat'] ?? 'N/A'); ?></p>
        <?php else: ?>
            <p>Aucune information sur ce match.</p>
        <?php endif; ?>

        <h2>Actions disponibles</h2>
        <div class="actions">
            <!-- Existing Buttons -->
            <?php if ($match['statut'] === 'À venir'): ?>
                <a href="../controllers/FeuilleMatchController.php?action=selectionner&id_match=<?= $match['id_match']; ?>" class="btn btn-select">
                    Sélectionner les joueurs
                </a>
            <?php endif; ?>

            <?php if ($match['statut'] === 'Terminé'): ?>
                <a href="../controllers/FeuilleMatchController.php?action=evaluer&id_match=<?= $match['id_match']; ?>" class="btn btn-evaluate">
                    Évaluer les joueurs
                </a>
            <?php endif; ?>

            <?php if ($match['statut'] === 'À venir'): ?>
            <a href="../controllers/FeuilleMatchController.php?action=supprimer&id_match=<?= $match['id_match']; ?>" class="btn btn-delete">
                Supprimer Joueurs de la Sélection
            </a>
            <?php endif; ?>
            
            <?php if ($match['etat_feuille'] === 'À venir'): ?>
            a href="../controllers/FeuilleMatchController.php?action=selectionner&id_match=<?= $match['id_match']; ?>" class="btn btn-select">
        Sélectionner les joueurs
    </a>
<?php endif; ?>
        </div>

        <h2>Liste des Joueurs pour ce Match</h2>
        <a href="../controllers/FeuilleMatchController.php?action=ajouter&id_match=<?= $match['id_match']; ?>" class="btn-index-match">Ajouter Joueur</a>

        <!-- Liste des Titulaires -->
        <h3>Titulaires</h3>
        <?php if (empty($titulaires)) : ?>
            <p>Aucun titulaire trouvé.</p>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Poste</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($titulaires as $joueur) : ?>
                        <tr>
                            <td><?= htmlspecialchars($joueur['nom_joueur'] ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($joueur['prenom_joueur'] ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($joueur['poste'] ?? 'N/A'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- Liste des Remplaçants -->
        <h3>Remplaçants</h3>
        <?php if (empty($remplacants)) : ?>
            <p>Aucun remplaçant trouvé.</p>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Poste</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($remplacants as $joueur) : ?>
                        <tr>
                            <td><?= htmlspecialchars($joueur['nom_joueur'] ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($joueur['prenom_joueur'] ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($joueur['poste'] ?? 'N/A'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </div>
</body>
</html>
<?php include '../views/footer.php'; ?>
