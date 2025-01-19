<?php
// controllers/MonCompteController.php

require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../config/database.php';

class MonCompteController {

    /**
     * Afficher les informations du compte utilisateur
     *
     * Cette méthode vérifie si l'utilisateur est connecté, 
     * récupère ses informations depuis la base de données, 
     * et les affiche dans la vue "mon_compte.php".
     */
    public function afficherMonCompte() {
        session_start();

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['id_utilisateur'])) {
            // Redirection vers la page de connexion si non connecté
            header("Location: index.php?controller=Connexion&action=afficherFormulaire");
            exit;
        }

        // Création d'une instance de connexion à la base de données
        $database = new Database();
        $db = $database->getConnection();

        // Création d'une instance du modèle Utilisateur
        $utilisateurModel = new Utilisateur($db);

        // Récupérer les informations de l'utilisateur connecté
        $user = $utilisateurModel->getUtilisateurParId($_SESSION['id_utilisateur']);

        // Charger la vue et transmettre les informations de l'utilisateur
        require_once __DIR__ . '/../views/mon_compte.php';
    }
}
