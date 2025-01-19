<?php

class Commentaire {
    private $conn;
    private $table = "commentaire";  // Your comment table

    public function __construct($db) {
        $this->conn = $db;
    }

    // Function to add a comment
    public function ajouterCommentaire($data) {
        $query = "INSERT INTO " . $this->table . " (sujet_commentaire, texte_commentaire, numero_licence) 
                  VALUES (:sujet_commentaire, :texte_commentaire, :numero_licence)";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":sujet_commentaire", $data['sujet_commentaire']);
        $stmt->bindParam(":texte_commentaire", $data['texte_commentaire']);
        $stmt->bindParam(":numero_licence", $data['numero_licence']);

        return $stmt->execute();
    }

    // Function to get comments for a player by their license number
    public function obtenirCommentairesParJoueur($numero_licence) {
        $query = "SELECT * FROM " . $this->table . " WHERE numero_licence = :numero_licence";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':numero_licence', $numero_licence);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function obtenirDernierCommentaireParJoueur($numero_licence) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE numero_licence = :numero_licence 
                  ORDER BY id_commentaire DESC 
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':numero_licence', $numero_licence);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC); // Return a single comment
    }
    
}
?>
