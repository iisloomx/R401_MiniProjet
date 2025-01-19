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
