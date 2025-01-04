<div class="container">
    <h1>Ajouter un Match</h1>
    <form action="MatchsController.php?action=ajouter" method="POST">
        <!-- Match Information -->
        <label for="equipe1">Équipe 1 :</label>
        <input type="text" name="equipe1" id="equipe1" required placeholder="Nom de l'équipe 1">

        <label for="equipe2">Équipe 2 :</label>
        <input type="text" name="equipe2" id="equipe2" required placeholder="Nom de l'équipe 2">

        <!-- Match Date -->
        <label for="date_match">Date :</label>
        <input type="date" name="date_match" id="date_match" required>

        <!-- Match Scores -->
        <label for="score_equipe1">Score Équipe 1 :</label>
        <input type="number" name="score_equipe1" id="score_equipe1" required min="0" placeholder="Score de l'équipe 1">

        <label for="score_equipe2">Score Équipe 2 :</label>
        <input type="number" name="score_equipe2" id="score_equipe2" required min="0" placeholder="Score de l'équipe 2">

        <!-- Submit Button -->
        <button type="submit">Ajouter</button>
    </form>
</div>
