<?php

require_once __DIR__ . '/../../config/database.php';

// Check if a match ID is provided in the URL
if (!isset($_GET['id'])) {
    echo "ID du match non spécifié.";
    exit;
}

// Retrieve match details
$id_match = intval($_GET['id']);
$sql = "SELECT * FROM match_ WHERE id_match = :id_match";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_match' => $id_match]);
$match = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the match exists
if (!$match) {
    echo "Match introuvable.";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $date_match = $_POST['date_match'];
    $heure_match = $_POST['heure_match'];
    $nom_equipe_adverse = $_POST['nom_equipe_adverse'];
    $lieu_de_rencontre = $_POST['lieu_de_rencontre'];
    $resultat = $_POST['resultat'];

    // Update the match
    $sql = "UPDATE match_ SET 
                date_match = :date_match,
                heure_match = :heure_match,
                nom_equipe_adverse = :nom_equipe_adverse,
                lieu_de_rencontre = :lieu_de_rencontre,
                resultat = :resultat
            WHERE id_match = :id_match";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'date_match' => $date_match,
        'heure_match' => $heure_match,
        'nom_equipe_adverse' => $nom_equipe_adverse,
        'lieu_de_rencontre' => $lieu_de_rencontre,
        'resultat' => $resultat,
        'id_match' => $id_match,
    ]);

    echo "Match modifié avec succès.";
    header("Location: index.php"); // Redirect to match list page
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Match</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container">
    <h1>Modifier le Match</h1>
    <form action="" method="POST">
        <label for="date_match">Date :</label>
        <input type="date" name="date_match" id="date_match" value="<?= htmlspecialchars($match['date_match']) ?>" required>

        <label for="heure_match">Heure :</label>
        <input type="time" name="heure_match" id="heure_match" value="<?= htmlspecialchars($match['heure_match']) ?>" required>

        <label for="nom_equipe_adverse">Nom de l'équipe adverse :</label>
        <input type="text" name="nom_equipe_adverse" id="nom_equipe_adverse" value="<?= htmlspecialchars($match['nom_equipe_adverse']) ?>" required>

        <label for="lieu_de_rencontre">Lieu de rencontre :</label>
        <select name="lieu_de_rencontre" id="lieu_de_rencontre" required>
            <option value="Domicile" <?= $match['lieu_de_rencontre'] === 'Domicile' ? 'selected' : '' ?>>Domicile</option>
            <option value="Extérieur" <?= $match['lieu_de_rencontre'] === 'Extérieur' ? 'selected' : '' ?>>Extérieur</option>
        </select>

        <label for="resultat">Résultat :</label>
        <input type="text" name="resultat" id="resultat" value="<?= htmlspecialchars($match['resultat']) ?>">

        <button type="submit">Modifier</button>
    </form>
</div>
</body>
</html>
