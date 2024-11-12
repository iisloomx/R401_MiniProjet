//liste joueurs
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Joueurs</title>
</head>
<body>
    <h1>Liste des Joueurs</h1>

    <?php if (!empty($joueurs)) : ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Numéro de Licence</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date de Naissance</th>
                    <th>Taille</th>
                    <th>Poids</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($joueurs as $j) : ?>
                    <tr>
                        <td><?= htmlspecialchars($j['numero_licence']); ?></td>
                        <td><?= htmlspecialchars($j['nom']); ?></td>
                        <td><?= htmlspecialchars($j['prenom']); ?></td>
                        <td><?= htmlspecialchars($j['date_naissance']); ?></td>
                        <td><?= htmlspecialchars($j['taille']); ?> m</td>
                        <td><?= htmlspecialchars($j['poids']); ?> kg</td>
                        <td><?= htmlspecialchars($j['statut']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Aucun joueur trouvé.</p>
    <?php endif; ?>
</body>
</html>
