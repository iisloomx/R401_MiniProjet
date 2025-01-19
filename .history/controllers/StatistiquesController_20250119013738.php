<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/database.php';
require_once '../models/Statistiques.php';

$database = new Database();
$db = $database->getConnection();
$statistiques = new Statistiques($db);

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'matchs':
        // Statistiques globales des matchs
        $stats = $statistiques->obtenirStatistiquesMatchs();
        require '../views/statistique_matchs.php';
        break;

    case 'joueurs':
        // Statistiques globales pour tous les joueurs
        $statsJoueurs = $statistiques->obtenirPourcentagesMatchs();
        require '../views/statistique_joueurs.php';
        break;

    case 'selection_joueur':
        // Sélections consécutives pour un joueur
        $joueurs = $statistiques->getAllPlayers();
        $numero_licence = $_GET['numero_licence'] ?? null;

        if ($numero_licence) {
            $consecutiveSelections = $statistiques->obtenirStatistiquesJoueurs($numero_licence);
        }

        require '../views/statistique_selection_joueur.php';
        break;

    case 'joueur_global':
        // Statistiques globales pour un joueur spécifique
        $joueurs = $statistiques->getAllPlayers();
        $numero_licence = $_GET['numero_licence'] ?? null;

        if ($numero_licence) {
            $stats = $statistiques->obtenirSelectionsConsecutives($numero_licence);
        }

        require '../views/statistique_joueur_global.php';
        break;

    default:
        // Redirection vers la vue principale des statistiques
        header("Location: ../views/statistique.php");
        exit;
}
?>
