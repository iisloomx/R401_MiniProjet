<?php
// On inclut le header s'il est nécessaire (vous l'avez déjà plus haut dans ajouter.php).
 include '../views/header.php'; // <-- Décommenter si vous en avez besoin ici

require_once '../config/database.php';
require_once '../models/Match.php';

// Connexion DB + instanciation de la classe
$database = new Database();
$db = $database->getConnection();
$gameMatch = new GameMatch($db);

// Récupération de l'action (paramètre GET)
$action = $_GET['action'] ?? 'liste';

switch ($action) {
    case 'liste':
        // 1. Récupère tous les matchs via le modèle
        $matchs = $gameMatch->obtenirTousLesMatchs();
        // 2. Charge la vue listant les matchs
        require '../views/matchs/index.php';
        break;

    case 'ajouter':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Récupération des données POST (correspondent au formulaire "ajouter.php")
            $data = [
                'equipe1'            => $_POST['equipe1'],
                'equipe2'            => $_POST['equipe2'],
                'score_equipe1'      => $_POST['score_equipe1'],
                'score_equipe2'      => $_POST['score_equipe2'],
                'date_match'         => $_POST['date_match'],
                'heure_match'        => $_POST['heure_match'],
                'nom_equipe_adverse' => $_POST['nom_equipe_adverse'],
                'lieu_de_rencontre'  => $_POST['lieu_de_rencontre'],
                'resultat'           => $_POST['resultat'],
            ];
            
            // 2. Insère en base via le modèle
            $gameMatch->ajouterMatch($data);

            // 3. Redirection vers la liste des matchs
            header("Location: MatchsController.php?action=liste");
            exit();
        }

        // Sinon (pas de POST) : on affiche simplement le formulaire d'ajout
        require '../views/matchs/ajouter.php';
        break;

        case 'modifier':
            $id_match = $_GET['id_match'] ?? null;
            if (!$id_match) {
                echo "ID du match non spécifié.";
                exit;
            }
        
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // On récupère les champs du formulaire
                $data = [
                    'id_match'           => $id_match,
                    'equipe1'            => $_POST['equipe1'],
                    'equipe2'            => $_POST['equipe2'],
                    'score_equipe1'      => $_POST['score_equipe1'],
                    'score_equipe2'      => $_POST['score_equipe2'],
                    'date_match'         => $_POST['date_match'],
                    'heure_match'        => $_POST['heure_match'],
                    'nom_equipe_adverse' => $_POST['nom_equipe_adverse'],
                    'lieu_de_rencontre'  => $_POST['lieu_de_rencontre'],
                    'resultat'           => $_POST['resultat'],
                ];
                // Appel du modèle pour mettre à jour
                $gameMatch->mettreAJourMatch($data);
                header("Location: MatchsController.php?action=liste");
                exit();
            }
        
            // Si on n’est pas en POST, on récupère le match
            $match = $gameMatch->obtenirMatch($id_match);
            require '../views/matchs/modifier.php';
            break;

case 'matches_a_venir': // Matches coming up (future matches)
    $matchs = $gameMatch->obtenirMatchsAVenir();
    require '../views/matchs/index.php';
    break;

case 'matches_passes': // Matches that have already happened
    $matchs = $gameMatch->obtenirMatchsPasses();
    require '../views/matchs/index.php';
    break;


    case 'supprimer':
        // 1. Récupérer l'ID
        $id_match = $_GET['id_match'] ?? null;
        // 2. Supprimer si on l'a
        if ($id_match) {
            $gameMatch->supprimerMatch($id_match);
        }
        // 3. Redirection vers la liste
        header("Location: MatchsController.php?action=liste");
        exit();

    default:
        // Par défaut, on liste
        $matchs = $gameMatch->obtenirTousLesMatchs();
        require '../views/matchs/index.php';
        break;
}
