<?php
session_start(); // Démarrez la session au début du fichier

// Vérifier que l'ID de l'utilisateur est bien présent dans la session
if (!isset($_SESSION['id_utilisateur'])) {
    // Si l'ID n'est pas défini, rediriger l'utilisateur vers la page de connexion
    header('Location: connexion.php');
    exit();
}

// Inclure le fichier de connexion DB et la classe Utilisateur
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Utilisateur.php';

// Créer la connexion PDO
$database = new Database();
$db = $database->getConnection();

// Créer l'instance du modèle Utilisateur
$utilisateurModel = new Utilisateur($db);

// Récupérer l'utilisateur par son ID stocké en session
$id_utilisateur = (int) $_SESSION['id_utilisateur']; // on force en int pour éviter toute injection
$user = $utilisateurModel->getUtilisateurParId($id_utilisateur);

// Inclure le header
require_once 'header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Compte</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Mon Compte</h1>

        <?php if ($user && isset($user['id_utilisateur'])): ?>
            <p><strong>ID Utilisateur :</strong> <?= htmlspecialchars($user['id_utilisateur'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Nom d’utilisateur :</strong> <?= htmlspecialchars($user['nom_utilisateur'], ENT_QUOTES, 'UTF-8') ?></p>
            <!-- On n’affiche pas le mot de passe pour des raisons de sécurité -->
        <?php else: ?>
            <p>Aucune information disponible pour l’utilisateur.</p>
        <?php endif; ?>

        <p>
            <a href="dashboard.php" class="btn">Retour au dashboard</a>
        </p>
    </div>
</body>
</html>