<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" href="/MiniprojetR3.01/views/css/style.css">
</head>
<body>
    <header class="main-header">
        <div class="logo">
            <a href="/MiniprojetR3.01/views/dashboard.php"><img src="../img/logo.PNG" alt="Logo" /></a>
        </div>
        
        <nav class="nav-links">
            <a href="/MiniprojetR3.01/views/dashboard.php">Accueil</a>
            <?php if (isset($_SESSION['utilisateur'])) : ?>
                <!-- Afficher "Mon Compte" et "Déconnexion" uniquement si l'utilisateur est connecté -->
                <a href="/MiniprojetR3.01/views/mon_compte.php" class="btn-account">Mon Compte</a>
                <a href="/MiniprojetR3.01/controllers/DeconnexionController.php" class="btn-logout">Déconnexion</a>
            <?php endif; ?>
        </nav>
    </header>
</body>
</html>