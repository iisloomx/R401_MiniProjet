<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../views/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Évaluation des joueurs</title>
    <link rel="stylesheet" href="../views/css/style.css">
    <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f9f9f9;
                margin: 0;
                padding: 0;
            }

            .container {
                width: 90%;
                max-width: 1200px;
                margin: 20px auto;
                background: #fff;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                padding: 20px;
                overflow-x: auto; /* Add horizontal scrollbar if content overflows */
            }

            h1 {
                text-align: center;
                color: #333;
            }

            .btn-back {
                display: inline-block;
                background-color: #3498db;
                color: white;
                padding: 10px 15px;
                border-radius: 5px;
                text-decoration: none;
                font-weight: bold;
                margin-bottom: 20px;
                transition: background-color 0.3s ease, transform 0.2s ease;
            }

            .btn-back:hover {
                background-color: #2980b9;
                transform: scale(1.05);
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
                table-layout: fixed; /* Ensures columns take up equal space */
            }

            table thead {
                background-color: #3498db;
                color: white;
            }

            table thead th {
                padding: 10px;
                text-align: left;
                font-weight: bold;
            }

            table tbody tr:nth-child(even) {
                background-color: #f4f4f4;
            }

            table tbody tr:hover {
                background-color: #eaf2f8;
            }

            table td {
                padding: 10px;
                border: 1px solid #ddd;
                text-align: center;
                vertical-align: middle;
                word-wrap: break-word; /* Prevent text from overflowing */
            }

            input[type="number"] {
                width: 80px; /* Limit width of evaluation fields */
                padding: 5px;
                border: 1px solid #ccc;
                border-radius: 4px;
                text-align: center;
            }

            button[type="submit"] {
                display: block;
                width: 100%;
                padding: 10px;
                background-color: #2ecc71;
                color: white;
                border: none;
                border-radius: 5px;
                font-size: 16px;
                font-weight: bold;
                margin-top: 20px;
                cursor: pointer;
                transition: background-color 0.3s ease, transform 0.2s ease;
            }

            button[type="submit"]:hover {
                background-color: #27ae60;
                transform: scale(1.02);
            }

            p {
                text-align: center;
                font-size: 16px;
                color: #666;
            }
    </style>
    <script>
        function toggleEvaluation(checkbox, index) {
            const evaluationField = document.getElementById(`evaluation_${index}`);
            evaluationField.disabled = !checkbox.checked;
            if (!checkbox.checked) {
                evaluationField.value = ''; // Réinitialiser la valeur
            }
        }

        function validateEvaluations(event) {
            const evaluations = document.querySelectorAll('input[type="number"]:not([disabled])');
            let isValid = true;

            evaluations.forEach((input) => {
                const value = parseInt(input.value, 10);
                if (isNaN(value) || value < 1 || value > 5) {
                    isValid = false;
                }
            });

            if (!isValid) {
                event.preventDefault();
                alert("Toutes les évaluations doivent être des nombres entre 1 et 5.");
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <a href="../controllers/FeuilleMatchController.php?action=afficher&id_match=<?= htmlspecialchars($id_match) ?>" class="btn btn-back">Retour</a>
        <h1>Évaluation des joueurs</h1>

        <?php if (!empty($participe)): ?>
            <form action="FeuilleMatchController.php?action=valider_evaluation&id_match=<?= htmlspecialchars($id_match) ?>" method="POST" onsubmit="validateEvaluations(event)">
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Poste</th>
                            <th>Rôle</th>
                            <th>Évaluer</th>
                            <th>Évaluation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($participe as $index => $joueur): ?>
                            <tr>
                                <td><?= htmlspecialchars($joueur['nom_joueur'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($joueur['prenom_joueur'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($joueur['poste'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($joueur['role'] ?? 'N/A'); ?></td>
                                <td>
                                    <input type="checkbox" id="checkbox_<?= $index ?>" onclick="toggleEvaluation(this, <?= $index ?>)">
                                </td>
                                <td>
                                    <input
                                        type="number"
                                        name="evaluations[<?= htmlspecialchars($joueur['numero_licence']) ?>]"
                                        id="evaluation_<?= htmlspecialchars($index) ?>"
                                        min="1"
                                        max="5"
                                        placeholder="1-5"
                                        disabled>
                                    <input
                                        type="hidden"
                                        name="roles[<?= htmlspecialchars($joueur['numero_licence']) ?>]"
                                        value="<?= htmlspecialchars($joueur['role']) ?>">
                                    <input
                                        type="hidden"
                                        name="postes[<?= htmlspecialchars($joueur['numero_licence']) ?>]"
                                        value="<?= htmlspecialchars($joueur['poste']) ?>">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit">Valider les Évaluations</button>
            </form>
        <?php else: ?>
            <p>Aucun joueur sélectionné pour ce match.</p>
        <?php endif; ?>
    </div>
</body>

</html>
