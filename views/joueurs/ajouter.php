<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Joueur</title>
</head>
<body>
    <h1>Ajouter un Nouveau Joueur</h1>
    <form action="JoueursController.php?action=ajouter" method="POST">
        <label for="numero_licence">Numéro de Licence :</label>
        <input type="text" name="numero_licence" id="numero_licence" required><br>
        <!-- Reste des champs du formulaire -->
        <button type="submit">Ajouter le Joueur</button>
    </form>
</body>
</html>
