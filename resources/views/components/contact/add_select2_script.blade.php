<script>


    function initIndividusSelect2(select2_id, modal_id = null) {
        $(document).ready(function() {
            $(select2_id).select2({
                dropdownParent: modal_id ? $(modal_id) : $('body'),
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

    function initEntitesSelect2(select2_id, modal_id = null) {
        $(document).ready(function() {
            $(select2_id).select2({
                dropdownParent: modal_id ? $(modal_id) : $('body'),
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

    function initContactsSelect2(select2_id, modal_id = null) {
        console.log($(select2_id));

        $(document).ready(function() {
            const $select = $(select2_id);
            $select.select2({
                dropdownParent: modal_id ? $(modal_id) : $('body'),
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
            });

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

    // Fonctions de formatage
            function formatContact(contact) {
                if (!contact.id) return contact.text;
                return $(`
            <div class="d-flex align-items-center">
                <div class="me-2">
                    <i class="mdi mdi-account-circle text-primary h4 mb-0"></i>
                </div>
                        <div>
                            <div class="font-weight-bold">${contact.nom} ${contact.prenom}</div>
                            <div class="small text-muted">
                        ${contact.email ? `<i class="mdi mdi-email text-danger"></i> ${contact.email}` : ''}
                        ${contact.telephone ? `<i class="mdi mdi-phone text-success"></i> ${contact.telephone}` : ''}
                            </div>
                        </div>
                    </div>
                `);
            }

            function formatContactSelection(contact) {
                if (!contact.id) return contact.text;
                return `${contact.nom} ${contact.prenom}`;
            }

    function formatEntite(entite) {
        if (!entite.id) return entite.text;
        return $(`
            <div class="d-flex align-items-center">
                <div class="me-2">
                    <i class="mdi mdi-domain text-info h4 mb-0"></i>
                </div>
                <div>
                    <div class="font-weight-bold">${entite.raison_sociale}</div>
                    <div class="small text-muted">
                        ${entite.email ? `<i class="mdi mdi-email text-danger"></i> ${entite.email}` : ''}
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

    function formatAllContact(contact) {
        if (!contact.id) return contact.text;
        return contact.type === 'individu' ? formatContact(contact) : formatEntite(contact);
    }

    function formatAllContactSelection(contact) {
        if (!contact.id) return contact.text;
        return contact.type === 'individu' ? formatContactSelection(contact) : formatEntiteSelection(contact);
    }
</script>