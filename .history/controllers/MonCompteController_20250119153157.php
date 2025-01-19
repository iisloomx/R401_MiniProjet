<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_utilisateur'])) {
    header('Location: connexion.php');
    exit();
}

// Inclure la base de données et le modèle Utilisateur
require_once '../config/database.php';
require_once '../models/Utilisateur.php';

// Créer la connexion PDO
$database = new Database();
$db = $database->getConnection();

// Créer une instance du modèle Utilisateur
$utilisateurModel = new Utilisateur($db);

// Déterminer l'action à exécuter
$action = $_GET['action'] ?? 'afficher';

switch ($action) {
    case 'afficher':
        // Récupérer les informations de l'utilisateur connecté
        $id_utilisateur = (int)$_SESSION['id_utilisateur'];
        $user = $utilisateurModel->getUtilisateurParId($id_utilisateur);

        // Charger la vue
        require '../views/mon_compte.php';
        break;

    case 'updatePassword':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_utilisateur = (int)$_SESSION['id_utilisateur'];
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            // Validation des données
            if (!$utilisateurModel->verifierUtilisateur($user['nom_utilisateur'], $current_password)) {
                $error = "Le mot de passe actuel est incorrect.";
            } elseif ($new_password !== $confirm_password) {
                $error = "Les mots de passe ne correspondent pas.";
            } elseif (strlen($new_password) < 6) {
                $error = "Le mot de passe doit contenir au moins 6 caractères.";
            } else {
                // Mise à jour du mot de passe
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $update_success = $utilisateurModel->updatePassword($id_utilisateur, $hashed_password);

                if ($update_success) {
                    $success = "Mot de passe changé avec succès.";
                } else {
                    $error = "Erreur lors de la mise à jour du mot de passe.";
                }
            }

            // Récupérer à nouveau l'utilisateur pour afficher les informations mises à jour
            $user = $utilisateurModel->getUtilisateurParId($id_utilisateur);
            require '../views/mon_compte.php';
        }
        break;

    default:
        echo "Action non reconnue.";
        break;
}
?>
