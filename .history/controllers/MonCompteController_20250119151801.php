<?php

require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../config/database.php';

class MonCompteController {

    public function afficherMonCompte() {
        session_start();

        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['id_utilisateur'])) {
            header("Location: connexion.php");
            exit;
        }

        // Connexion à la base de données
        $database = new Database();
        $db = $database->getConnection();

        $utilisateurModel = new Utilisateur($db);

        // Récupérer les informations utilisateur
        $id_utilisateur = (int) $_SESSION['id_utilisateur'];
        $user = $utilisateurModel->getUtilisateurParId($id_utilisateur);

        // Variables pour afficher des messages
        $error = "";
        $success = "";

        // Charger la vue
        require_once '../views/mon_compte.php';
    }

    public function updatePassword() {
        session_start();

        if (!isset($_SESSION['id_utilisateur'])) {
            header("Location: connexion.php");
            exit;
        }

        // Connexion à la base de données
        $database = new Database();
        $db = $database->getConnection();

        $utilisateurModel = new Utilisateur($db);

        $id_utilisateur = (int) $_SESSION['id_utilisateur'];
        $user = $utilisateurModel->getUtilisateurParId($id_utilisateur);

        $error = "";
        $success = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            // Validation
            if (!$utilisateurModel->verifierUtilisateur($user['nom_utilisateur'], $current_password)) {
                $error = "Le mot de passe actuel est incorrect.";
            } elseif ($new_password !== $confirm_password) {
                $error = "Les mots de passe ne correspondent pas.";
            } elseif (strlen($new_password) < 6) {
                $error = "Le mot de passe doit contenir au moins 6 caractères.";
            } else {
                // Mise à jour du mot de passe
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                if ($utilisateurModel->updatePassword($id_utilisateur, $hashed_password)) {
                    $success = "Mot de passe changé avec succès.";
                } else {
                    $error = "Erreur lors de la mise à jour du mot de passe.";
                }
            }
        }

        // Recharge la vue avec les messages
        require_once '../views/mon_compte.php';
    }
}

// Routeur pour gérer les actions
$action = $_GET['action'] ?? 'afficherMonCompte';
$controller = new MonCompteController();

if ($action === 'updatePassword') {
    $controller->updatePassword();
} else {
    $controller->afficherMonCompte();
}
