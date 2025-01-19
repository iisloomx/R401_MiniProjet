<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
} 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>Modifier un Joueur</title>
</head>
<body>
    <h1>Modifier le Joueur</h1>
    <form action="JoueursController.php?action=modifier&numero_licence=<?= urlencode($joueur_info['numero_licence']); ?>" method="POST">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($joueur_info['nom']); ?>" required><br>

        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($joueur_info['prenom']); ?>" required><br>

        <label for="date_naissance">Date de Naissance :</label>
        <input type="date" name="date_naissance" id="date_naissance" value="<?= htmlspecialchars($joueur_info['date_naissance']); ?>" required><br>

        <label for="taille">Taille (cm) :</label>
        <input type="number" name="taille" id="taille" value="<?= htmlspecialchars($joueur_info['taille']); ?>" required><br>

        <label for="poids">Poids (kg) :</label>
        <input type="number" name="poids" id="poids" value="<?= htmlspecialchars($joueur_info['poids']); ?>" required><br>

        <label>Statut :</label><br>
        <input type="radio" id="actif" name="statut" value="Actif" <?= $joueur_info['statut'] === 'Actif' ? 'checked' : ''; ?>>
        <label for="actif">Actif</label><br>

        <input type="radio" id="blesse" name="statut" value="Blessé" <?= $joueur_info['statut'] === 'Blessé' ? 'checked' : ''; ?>>
        <label for="blesse">Blessé</label><br>

        <input type="radio" id="suspendu" name="statut" value="Suspendu" <?= $joueur_info['statut'] === 'Suspendu' ? 'checked' : ''; ?>>
        <label for="suspendu">Suspendu</label><br>

        <input type="radio" id="absent" name="statut" value="Absent" <?= $joueur_info['statut'] === 'Absent' ? 'checked' : ''; ?>>
        <label for="absent">Absent</label><br>

        <button type="submit">Mettre à jour le Joueur</button>
    </form>
</body>
</html>
<?php include '../views/footer.php'; ?>
