<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un joueur</title>
    <link rel="stylesheet" href="../views/css/style.css">
</head>
<body>
    <div class="form-container">
        <h1>Ajouter un nouveau joueur</h1>
        <form action="JoueursController.php?action=ajouter" method="post">
            <div class="form-group">
                <label for="numero_licence">Numéro de licence:</label>
                <input type="text" name="numero_licence" id="numero_licence" required>
            </div>

            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" name="nom" id="nom" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom:</label>
                <input type="text" name="prenom" id="prenom" required>
            </div>

            <div class="form-group">
                <label for="date_naissance">Date de naissance:</label>
                <input type="date" name="date_naissance" id="date_naissance" required>
            </div>

            <div class="form-group">
                <label for="taille">Taille (cm):</label>
                <input type="number" name="taille" id="taille" required>
            </div>

            <div class="form-group">
                <label for="poids">Poids (kg):</label>
                <input type="number" name="poids" id="poids" required>
            </div>

            <div class="form-group">
                <label>Statut:</label>
                <div class="radio-group">
                    <input type="radio" name="statut" value="Actif" id="actif" checked>
                    <label for="actif">Actif</label>

                    <input type="radio" name="statut" value="Blessé" id="blesse">
                    <label for="blesse">Blessé</label>

                    <input type="radio" name="statut" value="Suspendu" id="suspendu">
                    <label for="suspendu">Suspendu</label>

                    <input type="radio" name="statut" value="Absent" id="absent">
                    <label for="absent">Absent</label>
                </div>
            </div>

            <button type="submit" class="btn">Ajouter</button>
        </form>
    </div>
</body>
</html>
