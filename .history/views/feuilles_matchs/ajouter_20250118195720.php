<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../views/header.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Joueur à la Feuille de Match</title>
    <link rel="stylesheet" href="../views/css/style.css">
</head>
<body>
<div class="container">
    <h1>Ajouter un Joueur à la Feuille de Match</h1>

    <!-- Afficher un message d'erreur s'il y en a -->
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="error-message">
            <?= htmlspecialchars($_SESSION['error']); ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="FeuilleMatchController.php?action=ajouter&id_match=<?= htmlspecialchars($id_match) ?>" method="POST">
        <input type="hidden" name="id_match" value="<?= htmlspecialchars($id_match) ?>">

        <!-- Sélection du joueur -->
        <div>
            <label for="numero_licence">Joueur :</label>
            <select name="numero_licence" id="numero_licence" required>
                <option value="">-- Sélectionner un joueur --</option>
                <?php foreach ($joueursNonSelectionnes as $joueur): ?>
                    <option value="<?= htmlspecialchars($joueur['numero_licence']) ?>">
                        <?= htmlspecialchars($joueur['nom']) . " " . htmlspecialchars($joueur['prenom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Rôle du joueur -->
        <div>
            <label for="role">Rôle :</label>
            <select name="role" id="role" required>
                <option value="">-- Sélectionner un rôle --</option>
                <option value="Titulaire">Titulaire</option>
                <option value="Remplaçant">Remplaçant</option>
            </select>
        </div>

        <!-- Poste du joueur -->
        <div>
            <label for="poste">Poste :</label>
            <select name="poste" id="poste" required>
                <option value="">-- Poste --</option>
                <option value="Gardien de But">Gardien de But</option>
                <option value="Défenseur Central">Défenseur Central</option>
                <option value="Défenseur Latéral">Défenseur Latéral</option>
                <option value="Arrière Latéral Offensif">Arrière Latéral Offensif</option>
                <option value="Libéro">Libéro</option>
                <option value="Milieu Défensif">Milieu Défensif</option>
                <option value="Milieu Central">Milieu Central</option>
                <option value="Milieu Offensif">Milieu Offensif</option>
                <option value="Milieu Latéral">Milieu Latéral</option>
                <option value="Attaquant Central">Attaquant Central</option>
                <option value="Avant-Centre">Avant-Centre</option>
                <option value="Ailier">Ailier</option>
                <option value="Second Attaquant">Second Attaquant</option>
            </select>
        </div>


        <!-- Bouton de soumission -->
        <button type="submit">Ajouter à la Feuille de Match</button>
    </form>
</div>
</body>
</html>
