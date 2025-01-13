<?php
require_once '../config/database.php';
require_once '../models/Participer.php';
require_once '../models/Joueur.php';
require_once '../models/Match.php';
require_once '../models/Commentaire.php';

$database = new Database();
$db = $database->getConnection();
$participer = new Participer($db);
$gameMatch = new GameMatch($db);
$joueur = new Joueur($db);
$commentaire = new Commentaire($db);


$action = $_GET['action'] ?? 'selectionner';

switch ($action) {
    case 'selectionner':
        $id_match = $_GET['id_match'] ?? null;
        if (!$id_match) {
            echo "ID du match non spécifié.";
            exit;
        }

        // Get the match details (date and time)
        $matchDetails = $gameMatch->obtenirMatch($id_match);
        $matchDateTime = $matchDetails['date_match'] . ' ' . $matchDetails['heure_match'];

        // Check if the match is in the future or past
        $isMatchInTheFuture = strtotime($matchDateTime) > time();

        // Get the active players
        $joueursActifs = $joueur->obtenirJoueursActifs();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($isMatchInTheFuture) {
                // Comptez les titulaires
                $titulaireCount = 0;
                foreach ($_POST['joueurs'] as $data) {
                    if ($data['role'] === 'Titulaire') {
                        $titulaireCount++;
                    }
                }
        
                // Vérifiez si le nombre de titulaires est suffisant
                $minimumPlayers = 11; // Par exemple, pour le football
                if ($titulaireCount < $minimumPlayers) {
                    $error = "Le nombre minimum de titulaires est $minimumPlayers.";
                } else {
                    foreach ($_POST['joueurs'] as $numero_licence => $data) {
                        $participer->ajouterSelection([
                            'numero_licence' => $numero_licence,
                            'id_match' => $id_match,
                            'role' => $data['role'],
                            'poste' => $data['poste'],
                            'evaluation' => null,
                        ]);
                    }
                    header("Location: FeuilleMatchController.php?action=selectionner&id_match=$id_match");
                    exit();
                }
            }
        }

        // Get the existing selections for the match
        $selections = $participer->obtenirSelectionsParMatch($id_match);

        // Pass whether the match is in the future to the view
        require '../views/selection/selectionner.php';
        break;

    case 'modifier_evaluation':
        $id = $_GET['id'] ?? null;
        $evaluation = $_GET['evaluation'] ?? null;

        if ($id && $evaluation !== null) {
            $participer->mettreAJourEvaluation($id, $evaluation);
            header("Location: FeuilleMatchController.php?action=selectionner&id_match=$_GET[id_match]");
            exit();
        }
        break;

    case 'supprimer':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $participer->supprimerSelection($id);
            header("Location: FeuilleMatchController.php?action=selectionner&id_match=$_GET[id_match]");
            exit();
        }
        break;

    default:
        echo "Action non supportée.";
        break;
}
?>
