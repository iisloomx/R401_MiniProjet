<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion / Inscription</title>
</head>
<body>
    <h2>Connexion</h2>
    <?php if (isset($erreur)) : ?>
        <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>
    
    <!-- Formulaire de connexion -->
    <form action="../controllers/ConnexionController.php" method="POST">
        <label for="nom_utilisateur">Nom d'utilisateur :</label>
        <input type="text" name="nom_utilisateur" id="nom_utilisateur" required><br>

        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" name="mot_de_passe" id="mot_de_passe" required><br>

        <button type="submit">Se connecter</button>
    </form>

    <hr>

    <!-- Redirection vers la page d'inscription -->
    <p>Pas encore de compte ? <a href="inscription.php">Créer un compte</a></p>
</body>
</html>
<?php if (isset($_GET['inscription']) && $_GET['inscription'] === 'success') : ?>
    <p style="color:green;">Compte créé avec succès. Vous pouvez maintenant vous connecter.</p>
<?php endif; ?>
