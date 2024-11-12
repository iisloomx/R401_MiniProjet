//ajouter des joueurs
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Joueur</title>
</head>
<body>
    <h1>Ajouter un Nouveau Joueur</h1>
    
    <form action="../../controllers/JoueursController.php?action=ajouter" method="POST">
        <label for="numero_licence">Numéro de Licence :</label>
        <input type="text" name="numero_licence" id="numero_licence" required><br>

        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" required><br>

        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" required><br>

        <label for="date_naissance">Date de Naissance :</label>
        <input type="date" name="date_naissance" id="date_naissance" required><br>

        <label for="taille">Taille (en mètres) :</label>
        <input type="number" step="0.01" name="taille" id="taille" required><br>

        <label for="poids">Poids (en kg) :</label>
        <input type="number" step="0.1" name="poids" id="poids" required><br>

        <label for="statut">Statut :</label>
        <select name="statut" id="statut" required>
            <option value="Actif">Actif</option>
            <option value="Blessé">Blessé</option>
            <option value="Suspendu">Suspendu</option>
            <option value="Absent">Absent</option>
        </select><br>

        <button type="submit">Ajouter le Joueur</button>
    </form>
</body>
</html>
