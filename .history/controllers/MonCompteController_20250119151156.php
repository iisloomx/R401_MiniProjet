<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérification de l'authentification
if (!isset($_SESSION['id_utilisateur'])) {
    header('Location: connexion.php');
    exit();
}

require_once '../config/database.php';
require_once '../models/Utilisateur.php';

// Création de la connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Création d'une instance du modèle utilisateur
$utilisateurModel = new Utilisateur($db);

// Récupération des informations utilisateur
$id_utilisateur = (int) $_SESSION['id_utilisateur'];
$user = $utilisateurModel->getUtilisateurParId($id_utilisateur);

$error = $success = "";

// Traitement du changement de mot de passe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validation des données
    if (!$utilisateurModel->verifierUtilisateur($user['nom_utilisateur'], $current_password)) {
        $error = "Le mot de passe actuel est incorrect.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } elseif (strlen($new_password) < 6) {
        $error = "Le mot de passe doit contenir au moins 6 caractères.";
    } else {
        // Mise à jour du mot de passe
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $update_success = $utilisateurModel->updatePassword($id_utilisateur, $hashed_password);

        if ($update_success) {
            $success = "Mot de passe changé avec succès.";
        } else {
            $error = "Erreur lors de la mise à jour du mot de passe.";
        }
    }
}

// Charger la vue
require_once '../views/mon_compte.php';
