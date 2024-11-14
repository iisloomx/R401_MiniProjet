<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Joueurs</title>
</head>
<body>
    <h1>Liste des Joueurs</h1>
    <a href="JoueursController.php?action=ajouter">Ajouter un joueur</a>
    <table border="1">
        <tr>
            <th>Numéro Licence</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Date de Naissance</th>
            <th>Taille</th>
            <th>Poids</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($joueurs as $j) : ?>
            <tr>
                <td><?= htmlspecialchars($j['numero_licence']); ?></td>
                <td><?= htmlspecialchars($j['nom']); ?></td>
                <td><?= htmlspecialchars($j['prenom']); ?></td>
                <td><?= htmlspecialchars($j['date_naissance']); ?></td>
                <td><?= htmlspecialchars($j['taille']); ?> m</td>
                <td><?= htmlspecialchars($j['poids']); ?> kg</td>
                <td><?= htmlspecialchars($j['statut']); ?></td>
                <td>
                    <a href="JoueursController.php?action=modifier&numero_licence=<?= urlencode($j['numero_licence']); ?>">Modifier</a>
                    <a href="JoueursController.php?action=supprimer&numero_licence=<?= urlencode($j['numero_licence']); ?>" onclick="return confirm('Voulez-vous vraiment supprimer ce joueur ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
