<?php
class Statistiques
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Récupérer les statistiques des matchs
    public function getMatchStats()
    {
        $stmt = $this->db->prepare("
            SELECT 
                COUNT(*) AS total,
                SUM(CASE WHEN score_equipe1 > score_equipe2 THEN 1 ELSE 0 END) AS victoires,
                SUM(CASE WHEN score_equipe1 < score_equipe2 THEN 1 ELSE 0 END) AS defaites,
                SUM(CASE WHEN score_equipe1 = score_equipe2 THEN 1 ELSE 0 END) AS nuls
            FROM match_
        ");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer les statistiques des joueurs
    public function getPlayerStats()
    {
        $stmt = $this->db->prepare("
            SELECT 
                j.numero_licence,
                j.nom,
                j.prenom,
                j.statut,
                COUNT(CASE WHEN p.role = 'Titulaire' THEN 1 END) AS titularisations,
                COUNT(CASE WHEN p.role = 'Remplaçant' THEN 1 END) AS remplacements,
                AVG(p.evaluation) AS moyenne_evaluations,
                COUNT(DISTINCT p.id_match) AS matchs_joues,
                SUM(CASE WHEN m.resultat = 'Victoire' THEN 1 ELSE 0 END) AS matchs_gagnes
            FROM joueur j
            LEFT JOIN participer p ON j.numero_licence = p.numero_licence
            LEFT JOIN match_ m ON p.id_match = m.id_match
            GROUP BY j.numero_licence
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
