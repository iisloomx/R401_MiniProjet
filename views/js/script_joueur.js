document.addEventListener('DOMContentLoaded', function () {
    const rows = document.querySelectorAll('#joueurs-table tbody tr');
    const modal = document.getElementById('action-modal');
    const editButton = document.getElementById('mod-button');
    const deleteButton = document.getElementById('supp-button');
    const closeModal = document.querySelector('.modal-content .close');

    rows.forEach(row => {
        row.addEventListener('click', function () {
            // Désélectionner les autres lignes
            rows.forEach(r => r.classList.remove('selected'));
            // Sélectionner la ligne cliquée
            row.classList.add('selected');
            
            // Récupérer l'ID du joueur sélectionné
            const playerId = row.getAttribute('data-id');
            
            // Mettre à jour les liens des boutons
            editButton.href = `../controllers/JoueursController.php?action=modifier&numero_licence=${encodeURIComponent(playerId)}`;
            deleteButton.href = `../controllers/JoueursController.php?action=supprimer&numero_licence=${encodeURIComponent(playerId)}`;
            
            // Afficher la fenêtre modale
            modal.style.display = 'block';
        });
    });

    // Fermer la fenêtre modale sur "Annuler"
    closeModal.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    // Fermer la fenêtre modale si on clique à l'extérieur
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});
