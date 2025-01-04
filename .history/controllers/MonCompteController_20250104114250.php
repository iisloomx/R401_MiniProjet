<?php
// controllers/MonCompteController.php

require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../config/database.php';

class MonCompteController {

    public function afficherMonCompte() {
        session_start();

        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['id_utilisateur'])) {
            // Redirection si non connecté
            header("Location: index.php?controller=Connexion&action=afficherFormulaire");
            exit;
        }

        // Créer une instance de connexion PDO
        $db = Database::getConnection();

        // Créer une instance du modèle
        $utilisateurModel = new Utilisateur($db);

        // Récupérer l’utilisateur par son id_utilisateur en session
        $user = $utilisateurModel->getUtilisateurParId($_SESSION['id_utilisateur']);

        // Inclure la vue mon_compte.php en lui passant $user
        require_once __DIR__ . '/../views/mon_compte.php';
    }
}
