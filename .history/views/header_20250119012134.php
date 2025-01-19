<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" href="/MiniprojetR3.01/views/css/style.css">
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <header class="main-header">
        <div class="logo">
            <a href="/MiniprojetR3.01/views/dashboard.php"><img src="../img/logo.PNG" alt="Logo" /></a>
        </div>
        
        <nav class="nav-links">
            <a href="/MiniprojetR3.01/views/dashboard.php">Accueil</a>
            
            <div class="dropdown">
                <a href="#" class="dropbtn">Menu</a>
                <div class="dropdown-content">
                    <a href="/MiniprojetR3.01/views/joueurs.php">Joueurs</a>
                    <a href="/MiniprojetR3.01/views/matchs.php">Matchs</a>
                    <a href="/MiniprojetR3.01/views/statistiques.php">Statistiques</a>
                </div>
            </div>
            
            <?php if (isset($_SESSION['utilisateur'])) : ?>
                <a href="/MiniprojetR3.01/views/mon_compte.php" class="btn-account">Mon Compte</a>
                <a href="/MiniprojetR3.01/controllers/DeconnexionController.php" class="btn-logout">Déconnexion</a>
            <?php endif; ?>
        </nav>
    </header>
</body>
</html>
