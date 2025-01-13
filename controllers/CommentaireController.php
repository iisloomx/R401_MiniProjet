<?php
require_once '../config/database.php';
require_once '../models/Commentaire.php';

$database = new Database();
$db = $database->getConnection();
$commentaire = new Commentaire($db);

$action = $_GET['action'] ?? 'ajouter_commentaire';

switch ($action) {
    case 'ajouter_commentaire':
        // Ensure we get the numero_licence from the GET request
        $numero_licence = $_GET['numero_licence'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle the form submission
            $data = [
                'sujet_commentaire' => $_POST['sujet_commentaire'],
                'texte_commentaire' => $_POST['texte_commentaire'],
                'numero_licence' => $numero_licence
            ];

            // Insert the comment into the database
            $commentaire->ajouterCommentaire($data);

            // Redirect back to the player list page
            header("Location: ../controllers/JoueursController.php?action=lister");
            exit();
        }

        // Display the comment form
        require '../views/commentaires/ajouter.php';
        break;

    default:
        echo "Action non supportée.";
        break;
}
?>
