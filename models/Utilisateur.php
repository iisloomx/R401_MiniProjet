<?php
require_once __DIR__ . '/../config/database.php';

class Utilisateur {
    private $conn;
    private $table_name = "Utilisateur";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Méthode pour vérifier les informations de connexion d'un utilisateur
    public function verifierUtilisateur($nom_utilisateur, $mot_de_passe) {
        $query = "SELECT mot_de_passe FROM " . $this->table_name . " WHERE nom_utilisateur = :nom_utilisateur";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nom_utilisateur', $nom_utilisateur);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row && password_verify($mot_de_passe, $row['mot_de_passe']);
    }

    // Méthode pour vérifier si un nom d'utilisateur existe déjà
    public function existeUtilisateur($nom_utilisateur) {
        $query = "SELECT id_utilisateur FROM " . $this->table_name . " WHERE nom_utilisateur = :nom_utilisateur";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nom_utilisateur', $nom_utilisateur);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    // Méthode pour ajouter un nouvel utilisateur avec un mot de passe haché
    public function ajouterUtilisateur($nom_utilisateur, $mot_de_passe) {
        $query = "INSERT INTO " . $this->table_name . " (nom_utilisateur, mot_de_passe) VALUES (:nom_utilisateur, :mot_de_passe)";
        $stmt = $this->conn->prepare($query);

        // Hachage du mot de passe pour la sécurité
        $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        $stmt->bindParam(':nom_utilisateur', $nom_utilisateur);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe_hache);

        return $stmt->execute();
    }
}
