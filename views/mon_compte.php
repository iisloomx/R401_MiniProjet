<?php require_once 'header.php'; ?>
<?php
// views/mon_compte.php

session_start();

// 1. Inclure le fichier de connexion DB et la classe Utilisateur
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Utilisateur.php';

// Vérifier que l'ID de l'utilisateur est bien présent dans la session
if (!isset($_SESSION['id_utilisateur'])) {
    // Si l'ID n'est pas défini, on peut soit rediriger l'utilisateur, soit afficher un message
    header('Location: connexion.php');
    exit();
}

// 2. Créer la connexion PDO
$database = new Database();
$db = $database->getConnection();

// 3. Créer l'instance du modèle Utilisateur
$utilisateurModel = new Utilisateur($db);

// 4. Récupérer l'utilisateur par son ID stocké en session
$id_utilisateur = (int) $_SESSION['id_utilisateur']; // on force en int pour éviter toute injection
$user = $utilisateurModel->getUtilisateurParId($id_utilisateur);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Compte</title>
</head>
<body>
    <h1>Mon Compte</h1>

    <?php if ($user && isset($user['id_utilisateur'])): ?>
        <p><strong>ID Utilisateur :</strong> <?= htmlspecialchars($user['id_utilisateur'], ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>Nom d’utilisateur :</strong> <?= htmlspecialchars($user['nom_utilisateur'], ENT_QUOTES, 'UTF-8') ?></p>
        <!-- On n’affiche pas le mot de passe pour des raisons de sécurité -->
    <?php else: ?>
        <p>Aucune information disponible pour l’utilisateur.</p>
    <?php endif; ?>

    <p>
        <a href="dashboard.php">Retour au dashboard</a>
    </p>
</body>
</html>
