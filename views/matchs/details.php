<!-- views/matchs/details.php -->
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
            <p><strong>Résultat :</strong> <?= htmlspecialchars($match['resultat']); ?></p>
        <?php else: ?>
            <p>Aucune information sur ce match.</p>
        <?php endif; ?>

        <h2>Liste des Joueurs pour ce Match</h2>
        <a href="../controllers/MatchsController.php?action=ajouter_joueur&id_match=<?= $match['id_match']; ?>" class="btn-index-match">Ajouter Joueur</a>

        <?php if (empty($participe)) : ?>
            <p>Aucun joueur trouvé.</p>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>Numéro de Licence</th>
                        <th>ID Match</th>
                        <th>Rôle</th>
                        <th>Poste</th>
                        <th>Évaluation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($participe as $joueur) : ?>
                        <tr>
                            <td><?= htmlspecialchars($joueur['numero_licence']); ?></td>
                            <td><?= htmlspecialchars($joueur['id_match']); ?></td>
                            <td><?= htmlspecialchars($joueur['rôle']); ?></td>
                            <td><?= htmlspecialchars($joueur['poste']); ?></td>
                            <td><?= htmlspecialchars($joueur['evaluation']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
