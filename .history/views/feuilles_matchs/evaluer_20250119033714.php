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
