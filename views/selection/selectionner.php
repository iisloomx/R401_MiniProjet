<?php include '../views/header.php'; ?>
<h2>Feuille de Match - Sélection des Joueurs</h2>

<?php if (isset($error)) { ?>
    <div style="color: red; margin-bottom: 20px;">
        <?php echo $error; ?>
    </div>
<?php } ?>

<?php if ($isMatchInTheFuture) { ?>
    <form action="FeuilleMatchController.php?action=selectionner&id_match=<?php echo $id_match; ?>" method="POST">
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Statut</th>
                    <th>Taille</th>
                    <th>Poids</th>
                    <th>Dernier Commentaire</th>
                    <th>Rôle</th>
                    <th>Poste</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($joueursActifs as $joueur) { 
                    // Optional: Get the last comment for the player
                    // $dernierCommentaire = $commentaire->obtenirDernierCommentaireParJoueur($joueur['numero_licence']);
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($joueur['nom']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['statut']); ?></td>
                        <td><?php echo htmlspecialchars($joueur['taille']); ?> cm</td>
                        <td><?php echo htmlspecialchars($joueur['poids']); ?> kg</td>
                        <td>
                            <?php // Example for last comment display
                            /* if ($dernierCommentaire) {
                                echo '<strong>' . htmlspecialchars($dernierCommentaire['sujet_commentaire']) . ':</strong> '
                                     . htmlspecialchars($dernierCommentaire['texte_commentaire']);
                            } else {
                                echo 'Aucun commentaire';
                            } */
                            ?>
                        </td>
                        <td>
                            <select name="joueurs[<?php echo $joueur['numero_licence']; ?>][role]" required>
                                <option value="Titulaire">Titulaire</option>
                                <option value="Remplaçant">Remplaçant</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="joueurs[<?php echo $joueur['numero_licence']; ?>][poste]" required>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <br>
        <button type="submit">Valider la Sélection</button>
        <a href="../controllers/MatchsController.php?action=liste" class="button" style="margin-left: 10px;">Retour</a>
    </form>
    
    <!-- ===================== -->
    <!-- Display Already Selected Players at the Bottom -->
    <!-- ===================== -->
    <h3 style="margin-top:40px;">Joueurs Sélectionnés pour ce Match</h3>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Rôle</th>
                <th>Poste</th>
                <th>Évaluation</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($selections)) {
                foreach ($selections as $selection) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($selection['nom']); ?></td>
                        <td><?php echo htmlspecialchars($selection['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($selection['role']); ?></td>
                        <td><?php echo htmlspecialchars($selection['poste']); ?></td>
                        <td>
                            <!-- If the match is in the future, no evaluation displayed -->
                            <?php if ($isMatchInTheFuture) {
                                echo 'Non disponible';
                            } else {
                                echo htmlspecialchars($selection['evaluation'] ?? 'Non évalué');
                            } ?>
                        </td>
                        <td>
                            <!-- Example: a link to remove the selection -->
                            <a href="FeuilleMatchController.php?action=supprimer&id=<?php echo $selection['id']; ?>&id_match=<?php echo $id_match; ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="6">Aucun joueur sélectionné</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

<?php } else { ?>
    <!-- Match is in the past -> Evaluations logic remains the same -->
    <h3>Le match est passé - Évaluation des joueurs</h3>
    <form action="FeuilleMatchController.php?action=selectionner&id_match=<?php echo $id_match; ?>" method="POST">
        <table border="1" cellpadding="10">
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
                        <td><?php echo htmlspecialchars($selection['nom']); ?></td>
                        <td><?php echo htmlspecialchars($selection['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($selection['poste']); ?></td>
                        <td>
                            <input type="number" name="evaluation[<?php echo $selection['id']; ?>]" 
                                   min="1" max="5" required 
                                   value="<?php echo htmlspecialchars($selection['evaluation'] ?? ''); ?>">
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <br>
        <button type="submit">Soumettre les Évaluations</button>
        <a href="../controllers/MatchsController.php?action=liste" class="button" style="margin-left: 10px;">Retour</a>
    </form>
<?php } ?>

<?php include '../views/footer.php'; ?>
