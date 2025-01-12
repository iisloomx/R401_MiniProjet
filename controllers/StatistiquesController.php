<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
} ?>
<?php include '../views/header.php'; ?>
<?php
require_once '../models/Statistiques.php';

if (isset($_GET['action']) && $_GET['action'] === 'afficher') {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=gestion_equipe_football;charset=utf8mb4', 'root', '');
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }

    $statistiquesModel = new Statistiques($pdo);

    // Récupérer les statistiques des matchs et des joueurs
    $matchStats = $statistiquesModel->getMatchStats();
    $playerStats = $statistiquesModel->getPlayerStats();

    // Inclure la vue
    include '../views/statistiques/statistiques.php';
    exit();
}
?>
