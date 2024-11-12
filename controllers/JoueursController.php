<?php
require_once '../config/database.php';
require_once '../models/Joueur.php';

class JoueursController {
    private $db;
    private $joueur;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->joueur = new Joueur($this->db);
    }

    // Méthode pour ajouter un joueur
    public function ajouterJoueur() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $data = [
                'numero_licence' => $_POST['numero_licence'],
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'date_naissance' => $_POST['date_naissance'],
                'taille' => $_POST['taille'],
                'poids' => $_POST['poids'],
                'statut' => $_POST['statut']
            ];

            // Appeler le modèle pour ajouter le joueur
            if ($this->joueur->ajouterJoueur($data)) {
                echo "Joueur ajouté avec succès!";
                header("Location: ../views/joueurs/index.php"); // Rediriger vers la liste des joueurs
                exit();
            } else {
                echo "Échec de l'ajout du joueur.";
            }
        }
    }
}

// Vérifier l'action à effectuer
$action = $_GET['action'] ?? null;
$controller = new JoueursController();

if ($action === 'ajouter') {
    $controller->ajouterJoueur();
}
?>
