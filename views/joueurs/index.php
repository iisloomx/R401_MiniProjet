<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Joueurs</title>
    <link rel="stylesheet" href="../views/css/style_joueur.css">
</head>
<body>
    <div class="table-container">
        <h1>Liste des Joueurs</h1>
        
        <a href="../controllers/JoueursController.php?action=ajouter" class="btn-add-joueur">Ajouter un Joueur</a>
        
        <?php if (!empty($joueurs)) : ?>
            <table id="joueurs-table">
                <thead>
                    <tr>
                        <th>Numéro Licence</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Date de Naissance</th>
                        <th>Taille</th>
                        <th>Poids</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($joueurs as $joueur) : ?>
                        <tr data-id="<?= htmlspecialchars($joueur['numero_licence']); ?>">
                            <td><?= htmlspecialchars($joueur['numero_licence']); ?></td>
                            <td><?= htmlspecialchars($joueur['nom']); ?></td>
                            <td><?= htmlspecialchars($joueur['prenom']); ?></td>
                            <td><?= htmlspecialchars($joueur['date_naissance']); ?></td>
                            <td><?= htmlspecialchars($joueur['taille']); ?> m</td>
                            <td><?= htmlspecialchars($joueur['poids']); ?> kg</td>
                            <td><?= htmlspecialchars($joueur['statut']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p class="no-data">Aucun joueur trouvé.</p>
        <?php endif; ?>
    </div>

    <!-- fenêtre modale -->
    <div id="action-modal" class="modal">
        <div class="modal-content">
            <p>Que voulez-vous faire avec ce joueur ?</p>
            <a href="#" class="edit" id="mod-button">Modifier</a>
            <a href="#" class="delete" id="supp-button" onclick="return confirm('Voulez-vous vraiment supprimer ce joueur ?');">Supprimer</a>
            <span class="close">Annuler</span>
        </div>
    </div>

    <script src="../views/js/script_joueur.js"></script>
</body>
</html>
