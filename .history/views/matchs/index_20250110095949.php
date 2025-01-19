<!-- views/matchs/index.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Matchs</title>
    <link rel="stylesheet" href="../views/css/style.css">
</head>
<body>
    <div class="table-container">
        <h1>Liste des Matchs</h1>
        
        <!-- Buttons to filter matches -->
        <div class="btn-group">
            <a href="../controllers/MatchsController.php?action=matches_a_venir" class="btn-add-match">
                Matchs à venir
            </a>
            <a href="../controllers/MatchsController.php?action=matches_passes" class="btn-add-match">
                Matchs passés
            </a>
        </div>
        
        <!-- Add Match Button -->
        <a href="../controllers/MatchsController.php?action=ajouter" class="btn-add-match">
            Ajouter un Match
        </a>
        
        <!-- Match List -->
        <?php if (!empty($matchs)) : ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Équipe Adverse</th>
                        <th>Lieu</th>
                        <th>Résultat</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($matchs as $match) : ?>
                        <tr>
                            <td><?= htmlspecialchars($match['id_match']); ?></td>
                            <td><?= htmlspecialchars($match['date_match']); ?></td>
                            <td><?= htmlspecialchars($match['heure_match']); ?></td>
                            <td><?= htmlspecialchars($match['nom_equipe_adverse']); ?></td>
                            <td><?= htmlspecialchars($match['lieu_de_rencontre']); ?></td>
                            <td><?= htmlspecialchars($match['resultat']); ?></td>
                            <td class="action-buttons">
                                <a href="../controllers/MatchsController.php?action=modifier&id_match=<?= $match['id_match']; ?>" class="edit">Modifier</a>
                                <a href="../controllers/MatchsController.php?action=supprimer&id_match=<?= $match['id_match']; ?>" class="delete">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p class="no-data">Aucun match trouvé.</p>
        <?php endif; ?>
    </div>
</body>
</html>
