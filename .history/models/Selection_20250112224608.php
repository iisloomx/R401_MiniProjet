class Participer {
    private $conn;
    private $table = "participer";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Ajouter un joueur à la sélection pour un match
    public function ajouterSelection($data) {
        $query = "INSERT INTO " . $this->table . " (numero_licence, id_match, role, poste, evaluation) 
                  VALUES (:numero_licence, :id_match, :role, :poste, :evaluation)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':numero_licence', $data['numero_licence']);
        $stmt->bindParam(':id_match', $data['id_match']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':poste', $data['poste']);
        $stmt->bindParam(':evaluation', $data['evaluation']);

        return $stmt->execute();
    }

    // Obtenir les joueurs sélectionnés pour un match
    public function obtenirSelectionsParMatch($id_match) {
        $query = "SELECT p.*, j.nom, j.prenom, j.statut, j.taille, j.poids, j.date_naissance 
                  FROM " . $this->table . " p
                  JOIN joueurs j ON p.numero_licence = j.numero_licence
                  WHERE p.id_match = :id_match";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_match', $id_match);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mettre à jour l'évaluation d'un joueur
    public function mettreAJourEvaluation($id, $evaluation) {
        $query = "UPDATE " . $this->table . " SET evaluation = :evaluation WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':evaluation', $evaluation);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Supprimer une sélection de joueur pour un match
    public function supprimerSelection($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
