<?php
require_once __DIR__ . '/../config/database.php';
class Joueur {
    private $conn;
    private $table_name = "Joueur";

    // Constructeur pour établir la connexion
    public function __construct($db) {
        $this->conn = $db;
    }

    // Méthode pour ajouter un joueur
    public function ajouterJoueur($data) {
        $query = "INSERT INTO " . $this->table_name . " (numero_licence, nom, prenom, date_naissance, taille, poids, statut) 
                  VALUES (:numero_licence, :nom, :prenom, :date_naissance, :taille, :poids, :statut)";
        $stmt = $this->conn->prepare($query);

        // Lier les valeurs pour éviter les injections SQL
        $stmt->bindParam(":numero_licence", $data['numero_licence']);
        $stmt->bindParam(":nom", $data['nom']);
        $stmt->bindParam(":prenom", $data['prenom']);
        $stmt->bindParam(":date_naissance", $data['date_naissance']);
        $stmt->bindParam(":taille", $data['taille']);
        $stmt->bindParam(":poids", $data['poids']);
        $stmt->bindParam(":statut", $data['statut']);

        // Exécuter la requête et retourner le résultat
        return $stmt->execute();
    }

    // Méthode pour obtenir tous les joueurs
    public function obtenirTousLesJoueurs() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour supprimer un joueur par son numéro de licence
    public function supprimerJoueur($numero_licence) {
        $query = "DELETE FROM " . $this->table_name . " WHERE numero_licence = :numero_licence";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":numero_licence", $numero_licence);

        return $stmt->execute();
    }
    
}
