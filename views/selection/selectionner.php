<?php include '../views/header.php'; ?>
<h2>Feuille de Match - Sélection des Joueurs</h2>

<?php if ($isMatchInTheFuture) { ?>
    <!-- If the match is in the future, allow player selection -->
    <form action="FeuilleMatchController.php?action=selectionner&id_match=<?php echo $id_match; ?>" method="POST">
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Statut</th>
                    <th>Taille</th>
                    <th>Poids</th>
                    <th>Rôle</th>
                    <th>Poste</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($joueursActifs as $joueur) { ?>
                    <tr>
                        <td><?php echo $joueur['nom']; ?></td>
                        <td><?php echo $joueur['prenom']; ?></td>
                        <td><?php echo $joueur['statut']; ?></td>
                        <td><?php echo $joueur['taille']; ?> cm</td>
                        <td><?php echo $joueur['poids']; ?> kg</td>
                        <td>
                            <select name="joueurs[<?php echo $joueur['numero_licence']; ?>][role]">
                                <option value="Titulaire">Titulaire</option>
                                <option value="Remplaçant">Remplaçant</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="joueurs[<?php echo $joueur['numero_licence']; ?>][poste]" required />
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <button type="submit">Ajouter joueur</button>
        <a href="../controllers/MatchsController.php?action=liste" class="button" style="display:inline-block; padding:10px 20px; background-color:#007bff; color:white; text-decoration:none; border-radius:5px;">Retour</a>
    </form>
<?php } else { ?>
    <!-- If the match has already passed, allow evaluations -->
    <form action="FeuilleMatchController.php?action=selectionner&id_match=<?php echo $id_match; ?>" method="POST">
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Poste</th>
                    <th>Évaluation (1 à 5)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($selections as $selection) { ?>
                    <tr>
                        <td><?php echo $selection['nom']; ?></td>
                        <td><?php echo $selection['prenom']; ?></td>
                        <td><?php echo $selection['poste']; ?></td>
                        <td>
                            <!-- Input for evaluation (1 to 5) -->
                            <input type="number" name="evaluation[<?php echo $selection['id']; ?>]" min="1" max="5" required value="<?php echo $selection['evaluation'] ?? ''; ?>" />
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <button type="submit">Soumettre les évaluations</button>
        <a href="../controllers/MatchsController.php?action=liste" class="button" style="display:inline-block; padding:10px 20px; background-color:#007bff; color:white; text-decoration:none; border-radius:5px;">Retour</a>

    </form>
    
<?php } ?>

<h3>Sélections existantes</h3>
<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Rôle</th>
            <th>Poste</th>
            <th>Évaluation</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($selections as $selection) { ?>
            <tr>
                <td><?php echo $selection['nom']; ?></td>
                <td><?php echo $selection['prenom']; ?></td>
                <td><?php echo $selection['role']; ?></td>
                <td><?php echo $selection['poste']; ?></td>
                <td>
                    <?php if ($isMatchInTheFuture) { ?>
                        <!-- If match is in the future, no evaluation available -->
                        <span>Évaluation non disponible</span>
                    <?php } else { ?>
                        <!-- If match has passed, allow evaluation -->
                        <?php if ($selection['evaluation'] === null) { ?>
                            <a href="FeuilleMatchController.php?action=modifier_evaluation&id=<?php echo $selection['id']; ?>&evaluation=5&id_match=<?php echo $id_match; ?>">Évaluer 5 étoiles</a>
                        <?php } else { ?>
                            <span><?php echo $selection['evaluation']; ?> étoiles</span>
                        <?php } ?>
                    <?php } ?>
                </td>
                <td>
                    <a href="FeuilleMatchController.php?action=supprimer&id=<?php echo $selection['id']; ?>&id_match=<?php echo $id_match; ?>">Supprimer</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php include '../views/footer.php'; ?>
