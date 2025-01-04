  <?php include '../views/header.php'; ?>
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
        $id_match = $_GET['id_match'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id_match' => $id_match,
                'date_match' => $_POST['date_match'],
                'heure_match' => $_POST['heure_match'],
                'nom_equipe_adverse' => $_POST['nom_equipe_adverse'],
                'lieu_de_rencontre' => $_POST['lieu_de_rencontre'],
                'resultat' => $_POST['resultat']
            ];
            $gameMatch->mettreAJourMatch($data);
            header("Location: MatchsController.php?action=liste");
            exit();
        }
        $match = $gameMatch->obtenirMatch($id_match);
        require '../views/matchs/modifier.php';
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
