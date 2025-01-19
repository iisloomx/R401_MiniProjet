<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$database = new Database();
$db = $database->getConnection();
$feuilleMatch = new FeuilleMatch($db);

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        // Afficher la page principale des statistiques
        require '../views/statistiques/statistiques.php';
        break;

    case 'matchs':
        // Récupérer les statistiques des matchs
        //$statsMatchs = $statistiqueModel->getMatchStats();
        require '../views/statistiques_matchs.php';
        break;

    case 'joueurs':
        // Récupérer les statistiques globales des joueurs
        //$statsJoueurs = $statistiqueModel->getPlayerStats();
        require '../views/statistiques_joueurs.php';
        break;

    default:
        echo "Action non reconnue.";
        break;
}
