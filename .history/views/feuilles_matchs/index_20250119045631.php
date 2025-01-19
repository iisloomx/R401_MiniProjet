<?php include '../views/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Match</title>
    <link rel="stylesheet" href="../views/css/style.css">
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const errorMessage = <?= json_encode($_SESSION['error'] ?? null) ?>;
            const successMessage = <?= json_encode($_SESSION['success'] ?? null) ?>;

            if (errorMessage) {
                alert(errorMessage);
            }
            if (successMessage) {
                alert(successMessage);
                window.location.href = "../controllers/MatchsController.php?action=liste"; // Redirect to matches list
            }
        });
    </script>
    <a href="../controllers/MatchsController.php?action=liste" class="btn btn-back">
        Retour à la liste des matchs
    </a>
</head>

<body>
    <div class="container">
            <h1>Détails du Match</h1>

            <!-- Affichage des informations du match -->
            <?php if (isset($match)): ?>
                <p><strong>Date :</strong> <?= htmlspecialchars($match['date_match']); ?></p>
                <p><strong>Heure :</strong> <?= htmlspecialchars($match['heure_match']); ?></p>
                <p><strong>Équipe Adverse :</strong> <?= htmlspecialchars($match['nom_equipe_adverse']); ?></p>
                <p><strong>Lieu :</strong> <?= htmlspecialchars($match['lieu_de_rencontre']); ?></p>
                <p><strong>Résultat :</strong> <?= htmlspecialchars($match['resultat'] ?? 'N/A'); ?></p>
            <?php else: ?>
                <p>Aucune information sur ce match.</p>
            <?php endif; ?>

            <h2>Actions disponibles</h2>
            <div class="actions">
                <?php if ($match['etat_feuille'] === 'Non validé' || $match['statut'] === 'À venir'): ?>
                    <a href="FeuilleMatchController.php?action=valider_feuille&id_match=<?= htmlspecialchars($match['id_match']); ?>"
                        class="btn btn-add">
                        Valider la Feuille de Match
                    </a>
                <?php elseif ($match['etat_feuille'] === 'Validé' && $match['statut'] === 'À venir'): ?>
                    <p>La feuille de match est validée, mais vous pouvez toujours la modifier.</p>
                <?php endif; ?>

                <!-- Actions disponibles, même après validation -->
                <?php if ($match['statut'] === 'À venir'): ?>
                    <a href="../controllers/FeuilleMatchController.php?action=ajouter&id_match=<?= $match['id_match']; ?>" class="btn btn-add">
                        Ajouter Joueur
                    </a>
            </div>
            
    </div>
</body>

</html>
<?php
// Nettoyage des messages après affichage
unset($_SESSION['error']);
unset($_SESSION['success']);
include '../views/footer.php';
?>