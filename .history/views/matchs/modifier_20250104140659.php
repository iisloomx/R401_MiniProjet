<?php
// Exemple d'inclusion du fichier config
require_once __DIR__ . '/../../config/database.php';

// --------------------------------------
// 1. Vérifier l'ID passé en GET
// --------------------------------------
if (!isset($_GET['id_match'])) {
    echo "ID du match non spécifié.";
    exit;
}

$id_match = intval($_GET['id_match']);

// --------------------------------------
// 2. Charger le match en base
// --------------------------------------
$sql = "SELECT * FROM match_ WHERE id_match = :id_match";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_match' => $id_match]);
$match = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$match) {
    echo "Match introuvable.";
    exit;
}

// --------------------------------------
// 3. Traiter l'envoi du formulaire (POST)
// --------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des champs
    $date_match         = $_POST['date_match'];
    $heure_match        = $_POST['heure_match'];
    $nom_equipe_adverse = $_POST['nom_equipe_adverse'];
    $lieu_de_rencontre  = $_POST['lieu_de_rencontre'];
    $resultat           = $_POST['resultat'];

    // Mise à jour en base
    $sql = "UPDATE match_
            SET date_match         = :date_match,
                heure_match        = :heure_match,
                nom_equipe_adverse = :nom_equipe_adverse,
                lieu_de_rencontre  = :lieu_de_rencontre,
                resultat           = :resultat
            WHERE id_match = :id_match";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'date_match'         => $date_match,
        'heure_match'        => $heure_match,
        'nom_equipe_adverse' => $nom_equipe_adverse,
        'lieu_de_rencontre'  => $lieu_de_rencontre,
        'resultat'           => $resultat,
        'id_match'           => $id_match,
    ]);

    // Redirection (vers un index ou une liste)
    header("Location: index.php");
    exit;
}
?>
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
    <form action="" method="POST">
        <label for="date_match">Date :</label>
        <input 
            type="date" 
            name="date_match" 
            id="date_match" 
            value="<?= htmlspecialchars($match['date_match']) ?>" 
            required
        >

        <label for="heure_match">Heure :</label>
        <input 
            type="time" 
            name="heure_match" 
            id="heure_match"
            value="<?= htmlspecialchars($match['heure_match']) ?>" 
            required
        >

        <label for="nom_equipe_adverse">Nom de l'équipe adverse :</label>
        <input 
            type="text" 
            name="nom_equipe_adverse" 
            id="nom_equipe_adverse" 
            value="<?= htmlspecialchars($match['nom_equipe_adverse']) ?>" 
            required
        >

        <label for="lieu_de_rencontre">Lieu de rencontre :</label>
        <select 
            name="lieu_de_rencontre" 
            id="lieu_de_rencontre" 
            required
        >
            <option value="Domicile"
                <?= $match['lieu_de_rencontre'] === 'Domicile' ? 'selected' : '' ?>
            >
                Domicile
            </option>
            <option value="Extérieur"
                <?= $match['lieu_de_rencontre'] === 'Extérieur' ? 'selected' : '' ?>
            >
                Extérieur
            </option>
        </select>

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
