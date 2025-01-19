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

    // Tableau pour chaque joueur
    public function obtenirStatistiquesJoueurs() {
        $query = "
            SELECT 
                j.numero_licence,
                j.nom,
                j.prenom,
                j.statut AS statut_actuel,
                (SELECT poste FROM participer WHERE numero_licence = j.numero_licence GROUP BY poste ORDER BY COUNT(*) DESC LIMIT 1) AS poste_prefere,
                COUNT(CASE WHEN p.role = 'Titulaire' THEN 1 END) AS titularisations,
                COUNT(CASE WHEN p.role = 'Remplaçant' THEN 1 END) AS remplacements,
                AVG(p.evaluation) AS moyenne_evaluations,
                COUNT(CASE WHEN m.resultat = 'Victoire' THEN 1 END) * 100.0 / COUNT(*) AS pourcentage_matchs_gagnes
            FROM joueur j
            LEFT JOIN participer p ON j.numero_licence = p.numero_licence
            LEFT JOIN match_ m ON p.id_match = m.id_match
            GROUP BY j.numero_licence, j.nom, j.prenom, j.statut;
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Nombre de sélections consécutives pour un joueur
    public function obtenirSelectionsConsecutives($numero_licence) {
        $query = "
            SELECT 
                MAX(consecutive_count) AS max_consecutive_selections
            FROM (
                SELECT 
                    numero_licence,
                    id_match,
                    ROW_NUMBER() OVER (PARTITION BY numero_licence ORDER BY id_match) - 
                    ROW_NUMBER() OVER (PARTITION BY numero_licence, id_match ORDER BY id_match) AS grp
                FROM participer
                WHERE numero_licence = :numero_licence
            ) AS grouped
            GROUP BY grp;
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':numero_licence', $numero_licence);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['max_consecutive_selections'];
    }
}
