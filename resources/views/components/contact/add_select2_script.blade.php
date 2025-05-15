<script>
    // Fonction utilitaire pour initialiser Select2 en préservant les options existantes
    function initSelect2WithDefault(select2_id, options = {}) {
        const $select = $(select2_id);
        
        // Récupérer toutes les options existantes
        const existingOptions = [];
        $select.find('option').each(function() {
            if ($(this).val()) { // Ignorer les options vides
                existingOptions.push({
                    id: $(this).val(),
                    text: $(this).text(),
                    selected: $(this).is(':selected')
                });
            }
        });

        // Si des options existent, les ajouter à la configuration
        if (existingOptions.length > 0) {
            options.data = existingOptions;
        }

        return options;
    }

    function initIndividusSelect2(select2_id) {
        $(document).ready(function() {
            $(select2_id).select2({
                placeholder: 'Rechercher un contact...',
                allowClear: true,
                minimumInputLength: 2,
                language: {
                    inputTooShort: () => 'Veuillez saisir au moins 2 caractères',
                    noResults: () => 'Aucun résultat trouvé',
                    searching: () => 'Recherche en cours...'
                },
                ajax: {
                    url: '{{ route('contact.search.individu') }}',
                    dataType: 'json',
                    delay: 250,
                    data: (params) => ({
                        q: params.term,
                        page: params.page
                    }),
                    processResults: (data) => ({
                        results: data.results
                    }),
                    cache: true
                },
                templateResult: formatContact,
                templateSelection: formatContactSelection
            });
        });
    }

    function initEntitesSelect2(select2_id) {
        $(document).ready(function() {
            $(select2_id).select2({
                placeholder: 'Rechercher une entreprise...',
                allowClear: true,
                minimumInputLength: 2,
                language: {
                    inputTooShort: () => 'Veuillez saisir au moins 2 caractères',
                    noResults: () => 'Aucune entreprise trouvée',
                    searching: () => 'Recherche en cours...'
                },
                ajax: {
                    url: '{{ route('contact.search.entite') }}',
                    dataType: 'json',
                    delay: 250,
                    data: (params) => ({
                        q: params.term,
                        page: params.page
                    }),
                    processResults: (data) => ({
                        results: data.results
                    }),
                    cache: true
                },
                templateResult: formatEntite,
                templateSelection: formatEntiteSelection
            });
        });
    }

    function initContactsSelect2(select2_id) {
        $(document).ready(function() {
            const $select = $(select2_id);
            
            // Configuration de base de Select2
            const select2Config = {
                placeholder: 'Rechercher un contact...',
                allowClear: true,
                minimumInputLength: 2,
                language: {
                    inputTooShort: () => 'Veuillez saisir au moins 2 caractères',
                    noResults: () => 'Aucun résultat trouvé',
                    searching: () => 'Recherche en cours...'
                },
                ajax: {
                    url: '{{ route('contact.search.all') }}',
                    dataType: 'json',
                    delay: 250,
                    data: (params) => ({
                        q: params.term,
                        page: params.page
                    }),
                    processResults: (data) => ({
                        results: data.results
                    }),
                    cache: true
                },
                templateResult: formatAllContact,
                templateSelection: formatAllContactSelection
            };

            // Initialiser Select2
            $select.select2(select2Config);

            // Gérer le changement de sélection
            $select.on('select2:select', function(e) {
                $('#current_contact').remove();
            });

            // Gérer la suppression de la sélection
            $select.on('select2:clear', function(e) {
                $('#current_contact').remove();
            });
        });
    }

    // Fonction pour formater l'affichage des résultats de recherche
    function formatContact(contact) {
        if (!contact.id) return contact.text;
        
        return $(`
            <div class="d-flex align-items-center" >
                <div>
                    <div class="font-weight-bold">${contact.nom} ${contact.prenom}</div>
                    <div class="small text-muted">
                        ${contact.email ? `<i class="mdi mdi-email text-danger"></i> ${contact.email}<br>` : ''}
                    </div>
                </div>
            </div>
        `);
    }

    // Fonction pour formater l'affichage de la sélection
    function formatContactSelection(contact) {
        if (!contact.id) return contact.text;
        return `${contact.nom} ${contact.prenom}`;
    }

    // Fonctions de formatage pour les entités
    function formatEntite(entite) {
        if (!entite.id) return entite.text;
        
        return $(`
            <div class="d-flex align-items-center">
                <div>
                    <div class="font-weight-bold">${entite.raison_sociale}</div>
                    <div class="small text-muted">
                        ${entite.email ? `<i class="mdi mdi-email text-danger"></i> ${entite.email}<br>` : ''}
                        ${entite.telephone ? `<i class="mdi mdi-phone text-success"></i> ${entite.telephone}` : ''}
                    </div>
                </div>
            </div>
        `);
    }

    function formatEntiteSelection(entite) {
        if (!entite.id) return entite.text;
        return entite.raison_sociale;
    }

    // Fonctions de formatage pour tous les contacts
    function formatAllContact(contact) {
        if (!contact.id) return contact.text;
        
        if (contact.type === 'individu') {
            return $(`
                <div class="d-flex align-items-center">
                    <div class="me-2">
                        <i class="mdi mdi-account-circle text-primary h4 mb-0"></i>
                    </div>
                    <div>
                        <div class="font-weight-bold">${contact.nom} ${contact.prenom}</div>
                        <div class="small text-muted">
                            ${contact.email ? `<i class="mdi mdi-email text-danger"></i> ${contact.email}<br>` : ''}
                            ${contact.telephone ? `<i class="mdi mdi-phone text-success"></i> ${contact.telephone}` : ''}
                        </div>
                    </div>
                </div>
            `);
        } else {
            return $(`
                <div class="d-flex align-items-center">
                    <div class="me-2">
                        <i class="mdi mdi-domain text-info h4 mb-0"></i>
                    </div>
                    <div>
                        <div class="font-weight-bold">${contact.raison_sociale}</div>
                        <div class="small text-muted">
                            ${contact.email ? `<i class="mdi mdi-email text-danger"></i> ${contact.email}<br>` : ''}
                            ${contact.telephone ? `<i class="mdi mdi-phone text-success"></i> ${contact.telephone}` : ''}
                        </div>
                    </div>
                </div>
            `);
        }
    }

    function formatAllContactSelection(contact) {
        if (!contact.id) return contact.text;
        return contact.type === 'individu' 
            ? `${contact.nom} ${contact.prenom}`
            : contact.raison_sociale;
    }
</script>