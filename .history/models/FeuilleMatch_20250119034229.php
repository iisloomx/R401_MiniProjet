<?php
class FeuilleMatch {
    private $conn;
    private $table = "participer";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Récupérer les joueurs d'une feuille de match
    public function obtenirJoueursParMatch($id_match) {
        $query = "SELECT j.nom AS nom_joueur, j.prenom AS prenom_joueur, p.role, p.poste, p.numero_licence
                FROM " . $this->table . " p
                JOIN joueur j ON p.numero_licence = j.numero_licence
                WHERE p.id_match = :id_match";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_match', $id_match);
        $stmt->bindParam(':numero_licence', $numero_licence, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function ajouterJoueur($data) {
        // Vérifier si le joueur est déjà enregistré pour ce match
        $queryCheck = "SELECT COUNT(*) as count FROM " . $this->table . " 
                       WHERE numero_licence = :numero_licence AND id_match = :id_match";
        $stmtCheck = $this->conn->prepare($queryCheck);
        $stmtCheck->bindParam(':numero_licence', $data['numero_licence']);
        $stmtCheck->bindParam(':id_match', $data['id_match']);
        $stmtCheck->execute();
        $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);
    
        if ($result['count'] > 0) {
            throw new Exception("Le joueur avec le numéro de licence " . $data['numero_licence'] . " est déjà sélectionné pour ce match.");
        }
    
        // Récupérer le nom et le prénom depuis la table `joueur`
        $queryJoueur = "SELECT nom, prenom FROM joueur WHERE numero_licence = :numero_licence";
        $stmtJoueur = $this->conn->prepare($queryJoueur);
        $stmtJoueur->bindParam(':numero_licence', $data['numero_licence']);
        $stmtJoueur->execute();
        $joueur = $stmtJoueur->fetch(PDO::FETCH_ASSOC);
    
        if (!$joueur) {
            throw new Exception("Joueur introuvable avec le numéro de licence " . $data['numero_licence']);
        }
    
        // Insérer le joueur dans la table `participer`
        $query = "INSERT INTO " . $this->table . " (numero_licence, nom_joueur, prenom_joueur, id_match, role, poste) 
                  VALUES (:numero_licence, :nom, :prenom, :id_match, :role, :poste)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':numero_licence', $data['numero_licence']);
        $stmt->bindParam(':nom', $joueur['nom']);
        $stmt->bindParam(':prenom', $joueur['prenom']);
        $stmt->bindParam(':id_match', $data['id_match']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':poste', $data['poste']);
    
        return $stmt->execute();
    }
    

    public function modifierSelection($data) {
        // Vérifier si les données sont présentes
        if (empty($data)) {
            throw new Exception("Aucun joueur sélectionné pour ce match.");
        }
    
        $query = "UPDATE " . $this->table . " 
                  SET role = :role, poste = :poste 
                  WHERE numero_licence = :numero_licence AND id_match = :id_match";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':poste', $data['poste']);
        $stmt->bindParam(':numero_licence', $data['numero_licence']);
        $stmt->bindParam(':id_match', $data['id_match']);
        
        $result = $stmt->execute();
        
        // Si la modification a réussi, mettre à jour l'état de la feuille
        if ($result) {
            $queryUpdateEtat = "UPDATE match_ SET etat_feuille = 'Non validé' WHERE id_match = :id_match";
            $stmtUpdateEtat = $this->conn->prepare($queryUpdateEtat);
            $stmtUpdateEtat->bindParam(':id_match', $data['id_match']);
            $stmtUpdateEtat->execute();
        }
    
        return $result;
    }
    
    public function mettreAJourEvaluation($numero_licence, $id_match, $evaluation) {
        $query = "UPDATE " . $this->table . " 
                  SET evaluation = :evaluation 
                  WHERE numero_licence = :numero_licence AND id_match = :id_match";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':evaluation', $evaluation, PDO::PARAM_INT);
        $stmt->bindParam(':numero_licence', $numero_licence, PDO::PARAM_STR);
        $stmt->bindParam(':id_match', $id_match, PDO::PARAM_INT);
    
        if (!$stmt->execute()) {
            throw new Exception("Impossible de mettre à jour l'évaluation pour le joueur {$numero_licence}.");
        }
        return true;
    }
    
    
    
    
    
    
    

    public function obtenirTitulairesParMatch($id_match) {
        $query = "SELECT j.nom AS nom_joueur, j.prenom AS prenom_joueur, p.role, p.poste, j.numero_licence
                  FROM " . $this->table . " p
                  JOIN joueur j ON p.numero_licence = j.numero_licence
                  WHERE p.id_match = :id_match AND p.role = 'Titulaire'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_match', $id_match);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    
    public function obtenirRemplacantsParMatch($id_match) {
        $query = "SELECT j.nom AS nom_joueur, j.prenom AS prenom_joueur, p.role, p.poste, j.numero_licence
                  FROM " . $this->table . " p
                  JOIN joueur j ON p.numero_licence = j.numero_licence
                  WHERE p.id_match = :id_match AND p.role = 'Remplaçant'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_match', $id_match);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return !empty($results) ? $results : null; 
    }

    public function obtenirJoueursNonSelectionnes($id_match) {
        $query = "
            SELECT j.numero_licence, j.nom, j.prenom, j.taille, j.poids
            FROM joueur j
            WHERE j.statut = 'Actif'
            AND j.numero_licence NOT IN (
                SELECT p.numero_licence
                FROM participer p
                WHERE p.id_match = :id_match
            )
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_match', $id_match);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function supprimerJoueurParLicenceEtMatch($numero_licence, $id_match) {
        // Supprimer le joueur du match
        $query = "DELETE FROM " . $this->table . " 
                  WHERE numero_licence = :numero_licence AND id_match = :id_match";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':numero_licence', $numero_licence);
        $stmt->bindParam(':id_match', $id_match);
        $result = $stmt->execute();
    
        // Mettre à jour l'état de la feuille si la suppression réussit
        if ($result) {
            $queryUpdateEtat = "UPDATE match_ SET etat_feuille = 'Non validé' WHERE id_match = :id_match";
            $stmtUpdateEtat = $this->conn->prepare($queryUpdateEtat);
            $stmtUpdateEtat->bindParam(':id_match', $id_match);
            $stmtUpdateEtat->execute();
        }
    
        return $result;
    }
    
    


    public function mettreAJourEtatMatch($id_match, $statut) {
        $query = "UPDATE `match_` SET etat_feuille = :statut WHERE id_match = :id_match";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':statut', $statut);
        $stmt->bindParam(':id_match', $id_match);
        return $stmt->execute();
    }
    
    
    public function obtenirMoyenneEvaluation($numero_licence) {
        $query = "SELECT AVG(evaluation) as moyenne 
                  FROM participer 
                  WHERE numero_licence = :numero_licence AND evaluation IS NOT NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':numero_licence', $numero_licence);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result['moyenne'] ?? null;
    }
    
    
    
    
}
?>
