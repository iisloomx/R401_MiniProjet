<?php include 'header.php'; ?>

<div class="form-container">
    <h2>Connexion</h2>
    <?php if (isset($erreur)) : ?>
        <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>
    
    <!-- Formulaire de connexion -->
    <form action="../controllers/ConnexionController.php" method="POST">
        <label for="nom_utilisateur">Nom d'utilisateur :</label>
        <input type="text" name="nom_utilisateur" id="nom_utilisateur" required>

        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" name="mot_de_passe" id="mot_de_passe" required>

        <button type="submit">Se connecter</button>
    </form>

    <p>Pas encore de compte ? <a href="inscription.php">Créer un compte</a></p>
</div>

<?php if (isset($_GET['inscription']) && $_GET['inscription'] === 'success') : ?>
    <p style="color:green; text-align: center;">Compte créé avec succès. Vous pouvez maintenant vous connecter.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
