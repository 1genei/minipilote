// Initialisation du planning
document.addEventListener('DOMContentLoaded', function() {
    initializeDragAndDrop();
    initializeSearch();
    initializeDatePicker();
});

// Gestion du drag & drop
function initializeDragAndDrop() {
    const produitItems = document.querySelectorAll('.produit-item');
    const timeCells = document.querySelectorAll('.time-cell');

    produitItems.forEach(item => {
        item.addEventListener('dragstart', handleDragStart);
        item.addEventListener('dragend', handleDragEnd);
    });

    timeCells.forEach(cell => {
        cell.addEventListener('dragover', handleDragOver);
        cell.addEventListener('dragleave', handleDragLeave);
        cell.addEventListener('drop', handleDrop);
    });
}

function handleDragStart(e) {
    e.target.classList.add('dragging');
    e.dataTransfer.setData('text/plain', JSON.stringify({
        produitId: e.target.dataset.produitId,
        beneficiaireId: e.target.dataset.beneficiaireId,
        commandeId: e.target.dataset.commandeId,
        html: e.target.innerHTML
    }));
}

function handleDragEnd(e) {
    e.target.classList.remove('dragging');
    document.querySelectorAll('.time-cell').forEach(cell => {
        cell.classList.remove('droppable');
    });
}

function handleDragOver(e) {
    e.preventDefault();
    if (!e.currentTarget.querySelector('.planning-event')) {
        e.currentTarget.classList.add('droppable');
    }
}

function handleDragLeave(e) {
    e.currentTarget.classList.remove('droppable');
}

function handleDrop(e) {
    e.preventDefault();
    const cell = e.currentTarget;
    cell.classList.remove('droppable');

    // Vérifier si la cellule est déjà occupée
    if (cell.querySelector('.planning-event')) {
        showToast('Cette plage horaire est déjà occupée', 'error');
        return;
    }

    try {
        const data = JSON.parse(e.dataTransfer.getData('text/plain'));
        const time = cell.dataset.time;
        
        // Créer l'événement dans le planning
        createPlanningEvent(cell, data, time);
        
        // Notification de succès
        showToast('Prestation planifiée avec succès', 'success');
    } catch (error) {
        console.error('Erreur lors du drop:', error);
        showToast('Une erreur est survenue', 'error');
    }
}

function createPlanningEvent(cell, data, time) {
    const event = document.createElement('div');
    event.className = 'planning-event';
    event.innerHTML = data.html;
    event.dataset.produitId = data.produitId;
    event.dataset.beneficiaireId = data.beneficiaireId;
    event.dataset.commandeId = data.commandeId;
    event.dataset.time = time;

    // Ajouter un bouton de suppression
    const deleteBtn = document.createElement('button');
    deleteBtn.className = 'planning-event-delete';
    deleteBtn.innerHTML = '<i class="mdi mdi-close"></i>';
    deleteBtn.onclick = function(e) {
        e.stopPropagation();
        if (confirm('Voulez-vous supprimer cette prestation du planning ?')) {
            event.remove();
            showToast('Prestation supprimée du planning', 'info');
        }
    };
    event.appendChild(deleteBtn);

    cell.appendChild(event);
}

// Gestion de la recherche
function initializeSearch() {
    const searchInput = document.getElementById('search-commande');
    if (!searchInput) return;

    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const commandeCards = document.querySelectorAll('.commande-card');

        commandeCards.forEach(card => {
            const numero = card.querySelector('.commande-numero').textContent.toLowerCase();
            const produits = Array.from(card.querySelectorAll('.produit-item'))
                .map(item => item.textContent.toLowerCase());

            const isVisible = numero.includes(searchTerm) || 
                            produits.some(produit => produit.includes(searchTerm));
            
            card.style.display = isVisible ? 'block' : 'none';
        });
    });
}

// Gestion du sélecteur de date
function initializeDatePicker() {
    const datePicker = document.getElementById('planning-date');
    const refreshBtn = document.getElementById('refresh-planning');
    
    if (!datePicker || !refreshBtn) return;

    refreshBtn.addEventListener('click', function() {
        const selectedDate = datePicker.value;
        if (!selectedDate) return;

        // Recharger les événements pour la date sélectionnée
        fetch(`/planning/events?date=${selectedDate}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Ici on pourra mettre à jour le planning avec les événements
                    showToast('Planning actualisé', 'success');
                } else {
                    showToast('Erreur lors de l\'actualisation', 'error');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showToast('Erreur lors de l\'actualisation', 'error');
            });
    });
}

// Utilitaire pour afficher des notifications
function showToast(message, type = 'info') {
    Swal.fire({
        text: message,
        icon: type,
        toast: true,
        position: 'top-center',
        width: '100%',
        padding: '20px',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
} 