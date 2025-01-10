<?php 
// On inclut le header, etc.
include '../views/header.php'; 

require_once '../config/database.php';
require_once '../models/Match.php';

// Connexion DB + Instanciation de la classe
$database = new Database();
$db = $database->getConnection();
$gameMatch = new GameMatch($db);

// Récupération de l'action dans l'URL
$action = $_GET['action'] ?? 'liste';

switch ($action) {
    case 'liste':
        // Liste de tous les matchs
        $matchs = $gameMatch->obtenirTousLesMatchs();
        require '../views/matchs/index.php';
        break;

    case 'ajouter':
        // Affichage du formulaire d'ajout d'un match, ou traitement du POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des données POST 
            // (doivent correspondre aux name="..." du formulaire)
            $data = [
                'equipe1'        => $_POST['equipe1'],
                'equipe2'        => $_POST['equipe2'],
                'date_match'     => $_POST['date_match'],
                'score_equipe1'  => $_POST['score_equipe1'],
                'score_equipe2'  => $_POST['score_equipe2'],
            ];
            
            // Appel à la méthode d'insertion
            $gameMatch->ajouterMatch($data);

            // Redirection vers la liste
            header("Location: MatchsController.php?action=liste");
            exit();
        }

        // Si on n'est pas encore en POST, on affiche juste la vue
        require '../views/matchs/ajouter.php';
        break;

    case 'modifier':
        // Récupérer l'ID du match dans l'URL : ?action=modifier&id_match=...
        $id_match = $_GET['id_match'] ?? null;
        if (!$id_match) {
            echo "ID du match non spécifié.";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // On met à jour avec le nouveau formulaire (mêmes champs que « ajouter »)
            $data = [
                'id_match'       => $id_match,
                'equipe1'        => $_POST['equipe1'],
                'equipe2'        => $_POST['equipe2'],
                'date_match'     => $_POST['date_match'],
                'score_equipe1'  => $_POST['score_equipe1'],
                'score_equipe2'  => $_POST['score_equipe2'],
            ];
            $gameMatch->mettreAJourMatch($data);
            header("Location: MatchsController.php?action=liste");
            exit();
        }

        // Récupération des infos du match pour pré-remplir le formulaire
        $match = $gameMatch->obtenirMatch($id_match);
        require '../views/matchs/modifier.php';
        break;

    case 'supprimer':
        $id_match = $_GET['id_match'] ?? null;
        if ($id_match) {
            $gameMatch->supprimerMatch($id_match);
        }
        header("Location: MatchsController.php?action=liste");
        exit();

    default:
        // Par défaut, on affiche la liste
        $matchs = $gameMatch->obtenirTousLesMatchs();
        require '../views/matchs/index.php';
        break;
}
