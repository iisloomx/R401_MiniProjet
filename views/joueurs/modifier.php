<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Joueur</title>
</head>
<body>
    <h1>Modifier le Joueur</h1>
    <form action="JoueursController.php?action=modifier&numero_licence=<?= urlencode($joueur_info['numero_licence']); ?>" method="POST">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($joueur_info['nom']); ?>" required><br>
        <!-- Reste des champs du formulaire -->
        <button type="submit">Mettre à jour le Joueur</button>
    </form>
</body>
</html>
