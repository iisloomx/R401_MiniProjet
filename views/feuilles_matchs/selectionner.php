<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
} include '../views/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Sélection des joueurs pour le match</title>
    <link rel="stylesheet" href="../views/css/style.css">
    <style>
        .player-selection {
            margin-bottom: 15px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }
        .player-info {
            margin-bottom: 10px;
        }
    </style>
    <script>
        function toggleFields(checkbox, index) {
            const roleField = document.getElementById(`role_${index}`);
            const posteField = document.getElementById(`poste_${index}`);
            const isEnabled = checkbox.checked;

            // Activer ou désactiver les champs associés
            roleField.disabled = !isEnabled;
            posteField.disabled = !isEnabled;

            // Enlever le required si désactivé
            if (!isEnabled) {
                roleField.removeAttribute('required');
                posteField.removeAttribute('required');
            } else {
                roleField.setAttribute('required', true);
                posteField.setAttribute('required', true);
            }
        }
    </script>
</head>
<body>
    <!-- Pop-up PHP -->
    <?php if (!empty($_GET['error']) && $_GET['error'] === 'not_enough_titulaires'): ?>
        <script>
            alert("Vous devez sélectionner au moins 11 joueurs titulaires pour valider la feuille de match.");
        </script>
    <?php endif; ?>

    <div class="container">
        <h1>Sélection des joueurs pour le match</h1>
        <form action="FeuilleMatchController.php?action=valider_selection&id_match=<?= htmlspecialchars($id_match) ?>" method="POST">
            <h2>Sélection des Joueurs</h2>
            <input type="hidden" name="id_match" value="<?= htmlspecialchars($id_match) ?>">

            <?php foreach ($joueursActifs as $index => $joueur): 
                // Vérifier si le joueur est déjà sélectionné pour ce match
                $isSelected = !empty($joueur['role']);
                $roleValue = $joueur['role'] ?? ''; // Pré-remplir le rôle si disponible
                $posteValue = $joueur['poste'] ?? ''; // Pré-remplir le poste si disponible
            ?>
                <div class="player-selection">
                    <label>
                        <input
                            type="checkbox"
                            name="joueur_selectionnes[<?= $index ?>][numero_licence]"
                            value="<?= htmlspecialchars($joueur['numero_licence']) ?>"
                            onclick="toggleFields(this, <?= $index ?>)"
                            <?= $isSelected ? 'checked' : '' ?>>
                        <?= htmlspecialchars($joueur['nom'] . ' ' . $joueur['prenom']) ?>
                    </label>
                    
                    <div class="player-info">
                        <p><strong>Taille :</strong> <?= htmlspecialchars($joueur['taille'] ?? 'N/A') ?> cm</p>
                        <p><strong>Poids :</strong> <?= htmlspecialchars($joueur['poids'] ?? 'N/A') ?> kg</p>
                        <p><strong>Dernier Commentaire :</strong> <?= htmlspecialchars($joueur['dernier_commentaire'] ?? 'Pas de commentaire') ?></p>
                        <p><strong>Évaluation :</strong> <?= htmlspecialchars($joueur['evaluation'] ?? 'Non évalué') ?></p>
                    </div>

                    <select id="role_<?= $index ?>" name="joueur_selectionnes[<?= $index ?>][role]" <?= $isSelected ? '' : 'disabled' ?> required>
                        <option value="">-- Rôle --</option>
                        <option value="Titulaire" <?= $roleValue === 'Titulaire' ? 'selected' : '' ?>>Titulaire</option>
                        <option value="Remplaçant" <?= $roleValue === 'Remplaçant' ? 'selected' : '' ?>>Remplaçant</option>
                    </select>
                    <select id="poste_<?= $index ?>" name="joueur_selectionnes[<?= $index ?>][poste]" <?= $isSelected ? '' : 'disabled' ?> required>
                        <option value="">-- Poste --</option>
                        <option value="Gardien de But" <?= $posteValue === 'Gardien de But' ? 'selected' : '' ?>>Gardien de But</option>
                        <option value="Défenseur Central" <?= $posteValue === 'Défenseur Central' ? 'selected' : '' ?>>Défenseur Central</option>
                        <option value="Défenseur Latéral" <?= $posteValue === 'Défenseur Latéral' ? 'selected' : '' ?>>Défenseur Latéral</option>
                        <option value="Arrière Latéral Offensif" <?= $posteValue === 'Arrière Latéral Offensif' ? 'selected' : '' ?>>Arrière Latéral Offensif</option>
                        <option value="Libéro" <?= $posteValue === 'Libéro' ? 'selected' : '' ?>>Libéro</option>
                        <option value="Milieu Défensif" <?= $posteValue === 'Milieu Défensif' ? 'selected' : '' ?>>Milieu Défensif</option>
                        <option value="Milieu Central" <?= $posteValue === 'Milieu Central' ? 'selected' : '' ?>>Milieu Central</option>
                        <option value="Milieu Offensif" <?= $posteValue === 'Milieu Offensif' ? 'selected' : '' ?>>Milieu Offensif</option>
                        <option value="Milieu Latéral" <?= $posteValue === 'Milieu Latéral' ? 'selected' : '' ?>>Milieu Latéral</option>
                        <option value="Attaquant Central" <?= $posteValue === 'Attaquant Central' ? 'selected' : '' ?>>Attaquant Central</option>
                        <option value="Avant-Centre" <?= $posteValue === 'Avant-Centre' ? 'selected' : '' ?>>Avant-Centre</option>
                        <option value="Ailier" <?= $posteValue === 'Ailier' ? 'selected' : '' ?>>Ailier</option>
                        <option value="Second Attaquant" <?= $posteValue === 'Second Attaquant' ? 'selected' : '' ?>>Second Attaquant</option>
                    </select>
                </div>
            <?php endforeach; ?>

            <button type="submit">Valider la Sélection</button>
        </form>
    </div>
</body>
</html>
