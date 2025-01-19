<?php
// controllers/MonCompteController.php

require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../config/database.php';

class MonCompteController {

    /**
     * Affiche les informations du compte utilisateur.
     */
    public function afficherMonCompte() {
        session_start();

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['id_utilisateur'])) {
            // Redirection vers la page de connexion si non connecté
            header("Location: connexion.php");
            exit;
        }

        // Création d'une instance de connexion à la base de données
        $database = new Database();
        $db = $database->getConnection();

        // Création d'une instance du modèle Utilisateur
        $utilisateurModel = new Utilisateur($db);

        // Récupérer les informations de l'utilisateur connecté
        $id_utilisateur = (int) $_SESSION['id_utilisateur'];
        $user = $utilisateurModel->getUtilisateurParId($id_utilisateur);

        // Charger la vue avec les informations de l'utilisateur
        require_once __DIR__ . '/../views/mon_compte.php';
    }

    /**
     * Gère le changement de mot de passe.
     */
    public function changerMotDePasse() {
        session_start();

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['id_utilisateur'])) {
            // Redirection vers la page de connexion si non connecté
            header("Location: connexion.php");
            exit;
        }

        // Création d'une instance de connexion à la base de données
        $database = new Database();
        $db = $database->getConnection();

        // Création d'une instance du modèle Utilisateur
        $utilisateurModel = new Utilisateur($db);

        // Récupérer l'utilisateur connecté
        $id_utilisateur = (int) $_SESSION['id_utilisateur'];
        $user = $utilisateurModel->getUtilisateurParId($id_utilisateur);

        $error = $success = "";

        // Gérer la soumission du formulaire de changement de mot de passe
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            // Validation des champs
            if (!$utilisateurModel->verifierUtilisateur($user['nom_utilisateur'], $current_password)) {
                $error = "Le mot de passe actuel est incorrect.";
            } elseif ($new_password !== $confirm_password) {
                $error = "Les mots de passe ne correspondent pas.";
            } elseif (strlen($new_password) < 6) {
                $error = "Le mot de passe doit contenir au moins 6 caractères.";
            } else {
                // Hacher le nouveau mot de passe et le mettre à jour
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $update_success = $utilisateurModel->updatePassword($id_utilisateur, $hashed_password);

                if ($update_success) {
                    $success = "Mot de passe changé avec succès.";
                } else {
                    $error = "Erreur lors de la mise à jour du mot de passe.";
                }
            }
        }

        // Charger la vue pour afficher les messages
        require_once __DIR__ . '/../views/mon_compte.php';
    }
}
