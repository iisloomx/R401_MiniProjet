<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../views/header.php'; ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <link rel="stylesheet" href="../views/css/style.css">
    <style>
        /* Styles CSS */
        .btn-stat {
            display: inline-block;
            background-color: #f39c12; /* Orange */
            color: white;
            font-weight: bold;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 10px 5px;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-stat:hover {
            background-color: #e67e22; /* Darker orange */
            transform: scale(1.05);
        }

        .btn-stat:visited {
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Statistiques</h1>
        <p>Choisissez le type de statistiques que vous souhaitez visualiser :</p>

        <div class="stat-buttons">
        <a href="../controllers/StatistiquesController.php?action=matchs" class="btn btn-stat">Statistiques des Matchs</a>
        <a href="../controllers/StatistiquesController.php?action=joueurs" class="btn btn-stat">Statistiques des Joueurs</a>

        </div>
    </div>
</body>

</html>