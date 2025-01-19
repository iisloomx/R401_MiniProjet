<?php
class GameMatch {
    private $conn;
    private $table = "match_"; // Nom de la table

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Récupère tous les matchs de la table
     */
    public function obtenirTousLesMatchs() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ajoute un match en BDD
     * On suppose que $data contient TOUTES les clés :
     *   'equipe1', 'equipe2', 'score_equipe1', 'score_equipe2',
     *   'date_match', 'heure_match', 'nom_equipe_adverse',
     *   'lieu_de_rencontre', 'resultat'
     */
    public function ajouterMatch($data) {
        $query = "
            INSERT INTO " . $this->table . " (
                equipe1,
                equipe2,
                score_equipe1,
                score_equipe2,
                date_match,
                heure_match,
                nom_equipe_adverse,
                lieu_de_rencontre,
                resultat
            ) VALUES (
                :equipe1,
                :equipe2,
                :score_equipe1,
                :score_equipe2,
                :date_match,
                :heure_match,
                :nom_equipe_adverse,
                :lieu_de_rencontre,
                :resultat
            )
        ";

        $stmt = $this->conn->prepare($query);

        // Liaison des paramètres
        $stmt->bindParam(':equipe1',            $data['equipe1']);
        $stmt->bindParam(':equipe2',            $data['equipe2']);
        $stmt->bindParam(':score_equipe1',      $data['score_equipe1']);
        $stmt->bindParam(':score_equipe2',      $data['score_equipe2']);
        $stmt->bindParam(':date_match',         $data['date_match']);
        $stmt->bindParam(':heure_match',        $data['heure_match']);
        $stmt->bindParam(':nom_equipe_adverse', $data['nom_equipe_adverse']);
        $stmt->bindParam(':lieu_de_rencontre',  $data['lieu_de_rencontre']);
        $stmt->bindParam(':resultat',           $data['resultat']);

        return $stmt->execute();
    }

    /**
     * Récupère les matchs passés
     */
    public function obtenirMatchsAVenir() {
        $query = "SELECT * FROM" . $this->table . "WHERE date_match > NOW()";  // Fetch matches with date > current date
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les matchs passés
     */
    public function obtenirMatchsPasses() {
        $query = "SELECT * FROM" . $this->table . "WHERE date_match < NOW()";  // Fetch matches with date < current date
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Supprime un match par son ID
     */
    public function supprimerMatch($id_match) {
        $query = "DELETE FROM " . $this->table . " WHERE id_match = :id_match";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_match', $id_match);
        return $stmt->execute();
    }

    /**
     * Récupère un match spécifique par son ID
     */
    public function obtenirMatch($id_match) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_match = :id_match";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_match', $id_match);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Met à jour un match existant
     * On suppose que $data contient 'id_match' ET tous les autres champs.
     */
    public function mettreAJourMatch($data) {
        $query = "
            UPDATE " . $this->table . " 
            SET
                equipe1            = :equipe1,
                equipe2            = :equipe2,
                score_equipe1      = :score_equipe1,
                score_equipe2      = :score_equipe2,
                date_match         = :date_match,
                heure_match        = :heure_match,
                nom_equipe_adverse = :nom_equipe_adverse,
                lieu_de_rencontre  = :lieu_de_rencontre,
                resultat           = :resultat
            WHERE id_match = :id_match
        ";

        $stmt = $this->conn->prepare($query);

        // Liaison des paramètres
        $stmt->bindParam(':equipe1',            $data['equipe1']);
        $stmt->bindParam(':equipe2',            $data['equipe2']);
        $stmt->bindParam(':score_equipe1',      $data['score_equipe1']);
        $stmt->bindParam(':score_equipe2',      $data['score_equipe2']);
        $stmt->bindParam(':date_match',         $data['date_match']);
        $stmt->bindParam(':heure_match',        $data['heure_match']);
        $stmt->bindParam(':nom_equipe_adverse', $data['nom_equipe_adverse']);
        $stmt->bindParam(':lieu_de_rencontre',  $data['lieu_de_rencontre']);
        $stmt->bindParam(':resultat',           $data['resultat']);
        $stmt->bindParam(':id_match',           $data['id_match']);

        return $stmt->execute();
    }
}
?>
