<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Match</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container">
    <h1>Modifier le Match</h1>

    <!-- 
      IMPORTANT:
      On envoie le formulaire vers 
      MatchsController.php?action=modifier&id_match=... 
      pour que le contrôleur traite la mise à jour 
    -->
    <form 
        action="MatchsController.php?action=modifier&id_match=<?= $match['id_match'] ?>" 
        method="POST">

        <!-- Date du match -->
        <label for="date_match">Date :</label>
        <input
            type="date"
            name="date_match"
            id="date_match"
            value="<?= htmlspecialchars($match['date_match']) ?>"
            required
        >

        <!-- Heure du match -->
        <label for="heure_match">Heure :</label>
        <input 
            type="time" 
            name="heure_match" 
            id="heure_match"
            value="<?= htmlspecialchars($match['heure_match']) ?>" 
        >

        <!-- Équipe 1 -->
        <label for="equipe1">Équipe 1 :</label>
        <input 
            type="text" 
            name="equipe1" 
            id="equipe1"
            value="<?= htmlspecialchars($match['equipe1'] ?? '') ?>"
        >

        <!-- Équipe 2 -->
        <label for="equipe2">Équipe 2 :</label>
        <input 
            type="text" 
            name="equipe2" 
            id="equipe2"
            value="<?= htmlspecialchars($match['equipe2'] ?? '') ?>"
        >

        <!-- Score Équipe 1 -->
        <label for="score_equipe1">Score Équipe 1 :</label>
        <input 
            type="number" 
            name="score_equipe1" 
            id="score_equipe1"
            value="<?= htmlspecialchars($match['score_equipe1'] ?? '') ?>"
            min="0"
        >

        <!-- Score Équipe 2 -->
        <label for="score_equipe2">Score Équipe 2 :</label>
        <input 
            type="number" 
            name="score_equipe2" 
            id="score_equipe2"
            value="<?= htmlspecialchars($match['score_equipe2'] ?? '') ?>"
            min="0"
        >

        <!-- Nom équipe adverse -->
        <label for="nom_equipe_adverse">Nom de l'équipe adverse :</label>
        <input 
            type="text" 
            name="nom_equipe_adverse" 
            id="nom_equipe_adverse"
            value="<?= htmlspecialchars($match['nom_equipe_adverse']) ?>"
        >

        <!-- Lieu de rencontre -->
        <label for="lieu_de_rencontre">Lieu de rencontre :</label>
        <select name="lieu_de_rencontre" id="lieu_de_rencontre">
            <option value="">-- Sélectionner --</option>
            <option value="Domicile"
                <?= isset($match['lieu_de_rencontre']) && $match['lieu_de_rencontre'] === 'Domicile' ? 'selected' : '' ?>
            >Domicile</option>
            <option value="Extérieur"
                <?= isset($match['lieu_de_rencontre']) && $match['lieu_de_rencontre'] === 'Extérieur' ? 'selected' : '' ?>
            >Extérieur</option>
        </select>

        <!-- Résultat -->
        <label for="resultat">Résultat :</label>
        <input 
            type="text" 
            name="resultat" 
            id="resultat"
            value="<?= htmlspecialchars($match['resultat']) ?>"
        >

        <button type="submit">Modifier</button>
    </form>
</div>
</body>
</html>