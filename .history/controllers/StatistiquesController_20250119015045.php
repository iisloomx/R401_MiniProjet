<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/database.php';
require_once '../models/Statistiques.php';
$database = new Database();
$db = $database->getConnection();
$Statistiques = new Statistiques($db);

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        // Afficher la page principale des statistiques
        require '../views/statistiques/statistiques.php';
        break;

    case 'matchs':
        $statistiquesModel = new Statistiques($db);

        // Obtenir les statistiques des matchs
        $totaux = $statistiquesModel->obtenirStatistiquesMatchs();
        $pourcentages = $statistiquesModel->obtenirPourcentagesMatchs();

        // Charger la vue statistiques_matchs.php avec les données
        require '../views/statistiques/statistiques_matchs.php';
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
