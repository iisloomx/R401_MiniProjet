<?php

class Statistiques {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Nombre total de matchs gagnés, nuls, perdus
    public function obtenirStatistiquesMatchs() {
        $query = "
            SELECT 
                COUNT(CASE WHEN resultat = 'Victoire' THEN 1 END) AS matchs_gagnes,
                COUNT(CASE WHEN resultat = 'Match Nul' THEN 1 END) AS matchs_nuls,
                COUNT(CASE WHEN resultat = 'Défaite' THEN 1 END) AS matchs_perdus
            FROM match_;
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Pourcentage de matchs gagnés, nuls, perdus
    public function obtenirPourcentagesMatchs() {
        $query = "
            SELECT 
                COUNT(*) AS total_matchs,
                COUNT(CASE WHEN resultat = 'Victoire' THEN 1 END) * 100.0 / COUNT(*) AS pourcentage_gagnes,
                COUNT(CASE WHEN resultat = 'Match Nul' THEN 1 END) * 100.0 / COUNT(*) AS pourcentage_nuls,
                COUNT(CASE WHEN resultat = 'Défaite' THEN 1 END) * 100.0 / COUNT(*) AS pourcentage_perdus
            FROM match_;
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


}
