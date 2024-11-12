<?php
session_start();
require_once '../config/database.php';
require_once '../models/Utilisateur.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Création d'une instance de connexion à la base de données
    $database = new Database();
    $db = $database->getConnection();
    
    // Création de l'objet utilisateur
    $utilisateur = new Utilisateur($db);

    // Récupération des données du formulaire
    $nom_utilisateur = trim($_POST['nom_utilisateur']);
    $mot_de_passe = $_POST['mot_de_passe'];

    // Vérification des informations de connexion
    if ($utilisateur->verifierUtilisateur($nom_utilisateur, $mot_de_passe)) {
        // Authentification réussie : démarrer la session utilisateur
        $_SESSION['utilisateur'] = $nom_utilisateur;
        header("Location: ../views/dashboard.php"); // Redirection vers le tableau de bord
        exit();
    } else {
        // Authentification échouée : message d'erreur
        $erreur = "Nom d'utilisateur ou mot de passe incorrect.";
        require '../views/connexion.php';
    }
} else {
    // Si la requête n'est pas en méthode POST, afficher le formulaire de connexion
    require '../views/connexion.php';
}
