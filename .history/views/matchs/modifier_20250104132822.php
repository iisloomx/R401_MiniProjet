<?php
// Include necessary files
require_once '../config/database.php'; // Database connection
require_once '../models/Match.php';    // Match model

// Start session and check authentication
session_start();
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: ../views/connexion.php");
    exit;
}

// Initialize variables
$matchId = $_GET['id'] ?? null;
$error = '';
$success = '';

// Fetch match details if an ID is provided
if ($matchId) {
    $match = Match::getMatchById($matchId);
    if (!$match) {
        $error = "Le match avec l'ID $matchId n'existe pas.";
    }
} else {
    $error = "Aucun ID de match fourni.";
}

// Update match details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $equipe1 = $_POST['equipe1'];
    $equipe2 = $_POST['equipe2'];
    $date_match = $_POST['date_match'];
    $score_equipe1 = $_POST['score_equipe1'];
    $score_equipe2 = $_POST['score_equipe2'];

    if ($matchId && $equipe1 && $equipe2 && $date_match !== '') {
        $updated = Match::updateMatch($matchId, $equipe1, $equipe2, $date_match, $score_equipe1, $score_equipe2);
        if ($updated) {
            $success = "Match modifié avec succès.";
        } else {
            $error = "Une erreur s'est produite lors de la modification du match.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/main.css">
    <title>Modifier un Match</title>
</head>
<body>
    <?php include '../views/header.php'; // Include the header ?>
    <div class="container">
        <h1>Modifier un Match</h1>
        <?php if ($error): ?>
            <p class="error-message"><?= htmlspecialchars($error); ?></p>
        <?php elseif ($success): ?>
            <p class="success-message"><?= htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <?php if ($match): ?>
            <form action="" method="POST">
                <label for="equipe1">Équipe 1 :</label>
                <input type="text" name="equipe1" id="equipe1" value="<?= htmlspecialchars($match['equipe1']); ?>" required>
                
                <label for="equipe2">Équipe 2 :</label>
                <input type="text" name="equipe2" id="equipe2" value="<?= htmlspecialchars($match['equipe2']); ?>" required>
                
                <label for="date_match">Date :</label>
                <input type="date" name="date_match" id="date_match" value="<?= htmlspecialchars($match['date_match']); ?>" required>
                
                <label for="score_equipe1">Score Équipe 1 :</label>
                <input type="number" name="score_equipe1" id="score_equipe1" value="<?= htmlspecialchars($match['score_equipe1']); ?>" min="0" required>
                
                <label for="score_equipe2">Score Équipe 2 :</label>
                <input type="number" name="score_equipe2" id="score_equipe2" value="<?= htmlspecialchars($match['score_equipe2']); ?>" min="0" required>
                
                <button type="submit">Enregistrer les modifications</button>
            </form>
        <?php endif; ?>
    </div>
    <?php include '../views/footer.php'; // Include the footer ?>
</body>
</html>
