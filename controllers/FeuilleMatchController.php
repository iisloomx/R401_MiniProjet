<?php
require_once '../config/database.php';
require_once '../models/Participer.php';
require_once '../models/Joueur.php';
require_once '../models/Match.php';

$database = new Database();
$db = $database->getConnection();
$participer = new Participer($db);
$gameMatch = new GameMatch($db);
$joueur = new Joueur($db);

$action = $_GET['action'] ?? 'selectionner';

switch ($action) {
    case 'selectionner':
        $id_match = $_GET['id_match'] ?? null;
        if (!$id_match) {
            echo "ID du match non spécifié.";
            exit;
        }

        // Obtenez les joueurs actifs
        $joueursActifs = $joueur->obtenirJoueursActifs();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ajoutez les joueurs sélectionnés
            foreach ($_POST['joueurs'] as $numero_licence => $data) {
                $participer->ajouterSelection([
                    'numero_licence' => $numero_licence,
                    'id_match' => $id_match,
                    'role' => $data['role'],
                    'poste' => $data['poste'],
                    'evaluation' => null, // Evaluation sera ajoutée après le match
                ]);
            }
            header("Location: FeuilleMatchController.php?action=selectionner&id_match=$id_match");
            exit();
        }

        // Obtenez les sélections existantes
        $selections = $participer->obtenirSelectionsParMatch($id_match);
        require '../views/feuille_match/selectionner.php';
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
