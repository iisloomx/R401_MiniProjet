<?php
class GameMatch {
    private $conn;
    private $table = "match_"; // Nom correct de la table

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenirTousLesMatchs() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouterMatch($data) {
        $query = "INSERT INTO " . $this->table . " (date_match, heure_match, nom_equipe_adverse, lieu_de_rencontre, resultat) 
                  VALUES (:date_match, :heure_match, :nom_equipe_adverse, :lieu_de_rencontre, :resultat)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':date_match', $data['date_match']);
        $stmt->bindParam(':heure_match', $data['heure_match']);
        $stmt->bindParam(':nom_equipe_adverse', $data['nom_equipe_adverse']);
        $stmt->bindParam(':lieu_de_rencontre', $data['lieu_de_rencontre']);
        $stmt->bindParam(':resultat', $data['resultat']);

        return $stmt->execute();
    }

    public function supprimerMatch($id_match) {
        $query = "DELETE FROM " . $this->table . " WHERE id_match = :id_match";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_match', $id_match);
        return $stmt->execute();
    }

    public function obtenirMatch($id_match) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_match = :id_match";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_match', $id_match);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function mettreAJourMatch($data) {
        $query = "UPDATE " . $this->table . " 
                  SET date_match = :date_match, 
                      heure_match = :heure_match, 
                      nom_equipe_adverse = :nom_equipe_adverse, 
                      lieu_de_rencontre = :lieu_de_rencontre, 
                      resultat = :resultat 
                  WHERE id_match = :id_match";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':date_match', $data['date_match']);
        $stmt->bindParam(':heure_match', $data['heure_match']);
        $stmt->bindParam(':nom_equipe_adverse', $data['nom_equipe_adverse']);
        $stmt->bindParam(':lieu_de_rencontre', $data['lieu_de_rencontre']);
        $stmt->bindParam(':resultat', $data['resultat']);
        $stmt->bindParam(':id_match', $data['id_match']);

        return $stmt->execute();
    }
}
?>
