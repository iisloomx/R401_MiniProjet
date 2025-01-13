<?php
require_once '../config/database.php';
require_once '../models/Match.php';

$database = new Database();
$db = $database->getConnection();
$gameMatch = new GameMatch($db);

$action = $_GET['action'] ?? 'liste';

switch ($action) {
    case 'liste':
        $matchs = $gameMatch->obtenirTousLesMatchs();
        require '../views/matchs/index.php';
        break;

    case 'ajouter':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'date_match' => $_POST['date_match'],
                'heure_match' => $_POST['heure_match'],
                'nom_equipe_adverse' => $_POST['nom_equipe_adverse'],
                'lieu_de_rencontre' => $_POST['lieu_de_rencontre'],
                'resultat' => $_POST['resultat']
            ];
            $gameMatch->ajouterMatch($data);
            header("Location: MatchsController.php?action=liste");
            exit();
        }
        require '../views/matchs/ajouter.php';
        break;

    case 'modifier':
        $id_match = $_GET['id_match'] ?? null;
        if (!$id_match) {
            echo "ID du match non spécifié.";
            exit;
        }

        // Get match details
        $match = $gameMatch->obtenirMatch($id_match);
        $matchDateTime = $match['date_match'] . ' ' . $match['heure_match'];
        $isMatchInThePast = strtotime($matchDateTime) < time(); // Check if the match is in the past

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Update match details
            $data = [
                'id_match' => $id_match,
                'equipe1' => $_POST['equipe1'],
                'equipe2' => $_POST['equipe2'],
                'date_match' => $_POST['date_match'],
                'heure_match' => $_POST['heure_match'],
                'nom_equipe_adverse' => $_POST['nom_equipe_adverse'],
                'lieu_de_rencontre' => $_POST['lieu_de_rencontre'],
                'resultat' => $isMatchInThePast ? $_POST['resultat'] : null // Only update result if the match is past
            ];

            // Update the match in the database
            $gameMatch->mettreAJourMatch($data);
            header("Location: MatchsController.php?action=liste");
            exit();
        }

        // Pass whether the match is in the past to the view
        require '../views/matchs/modifier.php';
        break;

    case 'matches_a_venir':
        $matchs = $gameMatch->obtenirMatchsAVenir();
        require '../views/matchs/index.php';
        break;

    case 'matches_passes':
        $matchs = $gameMatch->obtenirMatchsPasses();
        require '../views/matchs/index.php';
        break;

    case 'details':
        $id_match = $_GET['id_match'] ?? null;
        if (!$id_match) {
            echo "ID du match non spécifié.";
            exit;
        }
        $match = $gameMatch->obtenirMatch($id_match);
        require '../views/matchs/details.php';
        break;

    case 'supprimer':
        $id_match = $_GET['id_match'];
        $gameMatch->supprimerMatch($id_match);
        header("Location: MatchsController.php?action=liste");
        exit();
        break;

    default:
        $matchs = $gameMatch->obtenirTousLesMatchs();
        require '../views/matchs/index.php';
        break;
}
?>
