<?php
session_start(); // Démarrez la session au début du fichier
include 'header.php';
?>

<div class="form-container">
    <h2>Connexion</h2>

    <!-- Message d'erreur en cas d'échec de connexion -->
    <?php if (isset($erreur)) : ?>
        <p class="error-message"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <!-- Formulaire de connexion -->
    <form action="../controllers/ConnexionController.php" method="POST">
        <label for="nom_utilisateur">Nom d'utilisateur :</label>
        <input type="text" name="nom_utilisateur" id="nom_utilisateur" required>

        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" name="mot_de_passe" id="mot_de_passe" required>

        <button type="submit" class="btn-submit">Se connecter</button>
    </form>

    <!-- Lien pour créer un compte -->
    <p class="create-account-container">
        Pas encore de compte ? <a href="inscription.php" class="create-account-link">Créer un compte</a>
    </p>
</div>

<!-- Message de succès après inscription -->
<?php if (isset($_GET['inscription']) && $_GET['inscription'] === 'success') : ?>
    <div class="success-container">
        <p class="success-message">Compte créé avec succès. Vous pouvez maintenant vous connecter.</p>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>