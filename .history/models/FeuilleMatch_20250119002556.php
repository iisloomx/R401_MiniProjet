<?php
class FeuilleMatch {
    private $conn;
    private $table = "participer";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Récupérer les joueurs d'une feuille de match
    public function obtenirJoueursParMatch($id_match) {
        $query = "SELECT j.nom AS nom_joueur, j.prenom AS prenom_joueur, p.role, p.poste
                  FROM " . $this->table . " p
                  JOIN joueur j ON p.numero_licence = j.numero_licence
                  WHERE p.id_match = :id_match";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_match', $id_match);
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
    
    

    public function supprimerJoueur($id) {
        // Récupérer l'id_match avant de supprimer
        $queryGetMatchId = "SELECT id_match FROM " . $this->table . " WHERE id = :id";
        $stmtGetMatchId = $this->conn->prepare($queryGetMatchId);
        $stmtGetMatchId->bindParam(':id', $id);
        $stmtGetMatchId->execute();
        $row = $stmtGetMatchId->fetch(PDO::FETCH_ASSOC);
        $id_match = $row['id_match'] ?? null;
    
        if (!$id_match) {
            var_dump("id_match not found for ID: " . $id); // Debugging
            return false; // Si aucun id_match n'est trouvé, arrêter la suppression
        }
    
        // Supprimer le joueur
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $result = $stmt->execute();
    
        // Si la suppression a réussi, mettre à jour l'état de la feuille
        if ($result) {
            $queryUpdateEtat = "UPDATE match_ SET etat_feuille = 'Non validé' WHERE id_match = :id_match";
            $stmtUpdateEtat = $this->conn->prepare($queryUpdateEtat);
            $stmtUpdateEtat->bindParam(':id_match', $id_match);
            
            // Debugging: Check if the query succeeds
            if (!$stmtUpdateEtat->execute()) {
                var_dump($stmtUpdateEtat->errorInfo()); // Debugging SQL errors
            }
        } else {
            var_dump($stmt->errorInfo()); // Debugging SQL errors during deletion
        }
    
        return $result;
    }
    

    // Évaluer un joueur après un match
    public function evaluerJoueur($data) {
        $query = "INSERT INTO " . $this->table . " (evaluation, id_match)
        VALUES (:evaluation, :id_match)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':evaluation', $data['evaluation'], PDO::PARAM_INT);
        $stmt->bindParam(':id_match', $data['id_match'], PDO::PARAM_INT);
    
        return $stmt->execute();
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
        $query = "DELETE FROM " . $this->table . " 
                  WHERE numero_licence = :numero_licence AND id_match = :id_match";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':numero_licence', $numero_licence);
        $stmt->bindParam(':id_match', $id_match);
        return $stmt->execute();
    }


    public function mettreAJourEtatMatch($id_match, $statut) {
        $query = "UPDATE `match_` SET etat_feuille = :statut WHERE id_match = :id_match";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':statut', $statut);
        $stmt->bindParam(':id_match', $id_match);
        return $stmt->execute();
    }
    
    
    
    
    
    
}
?>
