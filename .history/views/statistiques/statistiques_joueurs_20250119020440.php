<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../views/header.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques Joueur</title>
    <link rel="stylesheet" href="../views/css/style.css">
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const joueurSelect = document.getElementById("numero_licence");
            const statsContainer = document.getElementById("stats-container");

            joueurSelect.addEventListener("change", () => {
                const numeroLicence = joueurSelect.value;

                if (numeroLicence) {
                    fetch(`../controllers/StatistiqueController.php?action=joueur_stats&numero_licence=${numeroLicence}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const stats = data.stats;
                                statsContainer.innerHTML = `
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Statistique</th>
                                                <th>Valeur</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Nom</td>
                                                <td>${stats.nom}</td>
                                            </tr>
                                            <tr>
                                                <td>Prénom</td>
                                                <td>${stats.prenom}</td>
                                            </tr>
                                            <tr>
                                                <td>Statut</td>
                                                <td>${stats.statut}</td>
                                            </tr>
                                            <tr>
                                                <td>Poste Préféré</td>
                                                <td>${stats.poste_prefere}</td>
                                            </tr>
                                            <tr>
                                                <td>Nombre de Titularisations</td>
                                                <td>${stats.nombre_titularisations}</td>
                                            </tr>
                                            <tr>
                                                <td>Nombre de Remplacements</td>
                                                <td>${stats.nombre_remplacements}</td>
                                            </tr>
                                            <tr>
                                                <td>Moyenne des Évaluations</td>
                                                <td>${stats.moyenne_evaluations}</td>
                                            </tr>
                                            <tr>
                                                <td>Pourcentage de Matchs Gagnés</td>
                                                <td>${stats.pourcentage_matchs_gagnes} %</td>
                                            </tr>
                                            <tr>
                                                <td>Nombre de Sélections Consécutives</td>
                                                <td>${stats.selections_consecutives}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                `;
                            } else {
                                statsContainer.innerHTML = `<p>${data.message}</p>`;
                            }
                        })
                        .catch(error => {
                            console.error("Erreur lors du chargement des statistiques :", error);
                            statsContainer.innerHTML = "<p>Erreur lors du chargement des statistiques.</p>";
                        });
                } else {
                    statsContainer.innerHTML = "<p>Sélectionnez un joueur pour voir ses statistiques.</p>";
                }
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Statistiques des Joueurs</h1>

        <!-- Liste déroulante pour sélectionner un joueur -->
        <div>
            <label for="numero_licence">Sélectionnez un joueur :</label>
            <select id="numero_licence" name="numero_licence">
                <option value="">-- Sélectionnez un joueur --</option>
                <?php foreach ($joueurs as $joueur): ?>
                    <option value="<?= htmlspecialchars($joueur['numero_licence']) ?>">
                        <?= htmlspecialchars($joueur['nom'] . ' ' . $joueur['prenom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Conteneur pour afficher les statistiques -->
        <div id="stats-container" style="margin-top: 20px;">
            <p>Sélectionnez un joueur pour voir ses statistiques.</p>
        </div>
    </div>
</body>
</html>
