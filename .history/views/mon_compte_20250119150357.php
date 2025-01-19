<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier que l'ID de l'utilisateur est bien présent dans la session
if (!isset($_SESSION['id_utilisateur'])) {
    // Si l'ID n'est pas défini, rediriger l'utilisateur vers la page de connexion
    header('Location: connexion.php');
    exit();
}

// Inclure le fichier de connexion DB et la classe Utilisateur
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Utilisateur.php';

// Créer la connexion PDO
$database = new Database();
$db = $database->getConnection();

// Créer l'instance du modèle Utilisateur
$utilisateurModel = new Utilisateur($db);

// Récupérer l'utilisateur par son ID stocké en session
$id_utilisateur = (int) $_SESSION['id_utilisateur']; // on force en int pour éviter toute injection
$user = $utilisateurModel->getUtilisateurParId($id_utilisateur);

// Gérer la soumission du formulaire de changement de mot de passe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validate the current password
    if (!$utilisateurModel->verifierUtilisateur($user['nom_utilisateur'], $current_password)) {
        $error = "Le mot de passe actuel est incorrect.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } elseif (strlen($new_password) < 6) {
        $error = "Le mot de passe doit contenir au moins 6 caractères.";
    } else {
        // Hash the new password and update it
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $update_success = $utilisateurModel->updatePassword($id_utilisateur, $hashed_password);

        if ($update_success) {
            $success = "Mot de passe changé avec succès.";
        } else {
            $error = "Erreur lors de la mise à jour du mot de passe.";
        }
    }
}

// Inclure le header
require_once 'header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Compte</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Mon Compte</h1>

        <?php if ($user && isset($user['id_utilisateur'])): ?>
            <p><strong>Nom d’utilisateur :</strong> <?= htmlspecialchars($user['nom_utilisateur'], ENT_QUOTES, 'UTF-8') ?></p>

            <!-- Formulaire de changement de mot de passe -->
            <h2>Changer de mot de passe</h2>
            <?php if (!empty($error)): ?>
                <p class="error-message"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <p class="success-message"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>

            <form action="" method="post" onsubmit="return confirmPasswordChange();">
                <div class="form-group">
                    <label for="current_password">Mot de passe actuel :</label>
                    <input type="password" name="current_password" id="current_password" required>
                </div>

                <div class="form-group">
                    <label for="new_password">Nouveau mot de passe :</label>
                    <input type="password" name="new_password" id="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirmer le mot de passe :</label>
                    <input type="password" name="confirm_password" id="confirm_password" required>
                </div>
                <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
            </form>

        <?php else: ?>
            <p>Aucune information disponible pour l’utilisateur.</p>
        <?php endif; ?>

        <p>
            <a href="dashboard.php" class="btn btn-back">Retour au dashboard</a>
        </p>
    </div>
    <script>
    function confirmPasswordChange() {
        // Display a confirmaion dialog
        return confirm("Êtes-vous sûr de vouloir changer votre mot de passe ?");
    }
    </script>
</body>
</html>