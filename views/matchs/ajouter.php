<?php include '../views/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ajouter un Match</title>
  <!-- Lien éventuel vers votre CSS -->
  <link rel="stylesheet" href="../views/css/style.css">
</head>
<body>

<?php include '../views/header.php'; ?>


<div class="container">
    <h1>Ajouter un Match</h1>
    <form action="MatchsController.php?action=ajouter" method="POST">
        
        <!-- Équipes et scores -->
        <div>
            <label for="equipe1">Nom de l'équipe:</label>
            <input 
                type="text" 
                name="equipe1" 
                id="equipe1" 
                required 
                placeholder="EX : CF Barcelona"
            >

        <!-- Équipe adverse -->
        
            <label for="nom_equipe_adverse">Nom de l'équipe adverse :</label>
            <input 
                type="text" 
                name="nom_equipe_adverse" 
                id="nom_equipe_adverse" 
                placeholder="Ex: CF Exemple"
            >
        
        </div>
        

        <!-- Date et heure du match -->
        <div>
            <label for="date_match">Date du match :</label>
            <input 
                type="date" 
                name="date_match" 
                id="date_match" 
                required
            >

            <label for="heure_match">Heure du match :</label>
            <input 
                type="time" 
                name="heure_match" 
                id="heure_match"
            >
        </div>
        


        <!-- Lieu de rencontre (domicile ou extérieur) -->
        <div>
            <label for="lieu_de_rencontre">Lieu de la rencontre :</label>
            <select name="lieu_de_rencontre" id="lieu_de_rencontre">
                <option value="">-- Sélectionner --</option>
                <option value="Domicile">Domicile</option>
                <option value="Extérieur">Extérieur</option>
            </select>
        </div>

        <!-- Résultat global du match (facultatif)
        <div>
            <label for="resultat">Résultat :</label>
            <input 
                type="text" 
                name="resultat" 
                id="resultat" 
                placeholder="Exemple : 3-2, Victoire, etc."
            >
        </div> -->
        
        <!-- Bouton de soumission -->
        <button type="submit">Ajouter</button>
    </form>
</div>

</body>
</html>
<?php include '../views/footer.php'; ?>

