@extends('layouts.app')

@section('title', 'Créer une facture')

@section('content')
<div class="content">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('facture.index') }}">Factures</a></li>
                        <li class="breadcrumb-item active">Créer</li>
                    </ol>
                </div>
                <h4 class="page-title">
                    @if($type === 'client')
                        Nouvelle facture client
                    @elseif($type === 'fournisseur')
                        Facture fournisseur
                    @else
                        Facture directe
                    @endif
                </h4>
            </div>
        </div>
        <div class="col-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row g-0">

                        <div class="col-sm-2 ">
                            <a href="{{ route('facture.index') }}" type="button" class="btn btn-outline-primary"><i
                                    class="uil-arrow-left"></i>
                                Factures</a>

                        </div>
                        @if (session('ok'))
                            <div class="col-6">
                                <div class="alert alert-success alert-dismissible bg-success text-white text-center border-0 fade show"
                                    role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    <strong> {{ session('ok') }}</strong>
                                </div>
                            </div>
                        @endif

                    </div> <!-- end row -->
                </div>
            </div> <!-- end card-box-->
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h4 class="header-title">
                        @if($commande)
                            Facture pour la commande N°{{ $commande->numero_commande }}
                        @else
                            Créer une facture
                        @endif
                    </h4>
                </div>
                <div class="card-body">
                    
                    @if($type === 'client' && !$commande)
                        <!-- Onglets pour facture client -->
                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#facture-simple" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0 active">
                                    <i class="mdi mdi-file-document me-1"></i> Facture simple
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#facture-multiple" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                    <i class="mdi mdi-file-multiple me-1"></i> Facture provenant d'une commande
                                </a>
                            </li>
                        </ul>
                    @endif

                    <div class="tab-content">
                        <!-- Facture simple -->
                        <div class="tab-pane show active" id="facture-simple">
                            <form action=""  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="type" value="{{ $type }}">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="numero" class="form-label">Numéro de facture</label>
                                            <input type="text" class="form-control" id="numero" name="numero" 
                                                           value="{{ $restoredData['numero'] ?? $prochain_numero}}" >   
                                        </div>

                                                
                                            </div>
                                            <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="date" class="form-label">Date de facture</label>
                                            <input type="date" class="form-control" id="date" name="date" 
                                                           value="{{ $restoredData['date'] ?? date('Y-m-d') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        

                                        @if($type === 'client')
                                            <div class="mb-3">
                                                <label for="client_id" class="form-label">Client</label>
                                                 @if(isset($restoredData['client_id']))
                                                    <input type="hidden" name="client_id" value="{{ $restoredData['client_id'] }}">
                                                    @php
                                                    $client = \App\Models\Contact::find($restoredData['client_id']);
                                                    if($client && $client->type == 'individu'){
                                                        $nom = $client->individu?->nom ?? '';
                                                        $nom .= " ".$client->individu?->prenom ?? '';
                                                    }else{
                                                        $nom = $client->entite?->raison_sociale ?? '';
                                                    }
                                                    @endphp
                                                  

                                                 <span class="badge bg-primary">{{ $nom }}</span>
                                                 @endif
                                                <select class=" form-control select2" data-toggle="select2" required id="client_id" name="client_id" required>
                                                    @if(isset($restoredData['client_id']))
                                                    <option value="{{ $restoredData['client_id'] }}">{{ $nom }}</option>
                                                    @else   
                                                    <option value="">Sélectionner un client</option>
                                                    @endif
                                                </select>
                                            </div>
                                        @elseif($type === 'fournisseur')
                                            <div class="mb-3">
                                                <label for="fournisseur_id" class="form-label">Fournisseur</label>
                                                <select class=" form-control select2" data-toggle="select2" required id="fournisseur_id" name="fournisseur_id" required>
                                                    <option value="">Sélectionner un fournisseur</option>
                                                   
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="numero_origine" class="form-label">Numéro de facture fournisseur</label>
                                                <input type="text" class="form-control" id="numero_origine" name="numero_origine" 
                                                       value="{{ $restoredData['numero_origine'] ?? '' }}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="fichier" class="form-label">Fichier de la facture</label>
                                                <input type="file" class="form-control" id="fichier" name="fichier" 
                                                       accept=".pdf,.jpg,.jpeg,.png">
                                                <small class="text-muted">Formats acceptés : PDF, JPG, PNG</small>
                                            </div>
                                        @endif

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <div id="description-editor" style="height: 300px;">
                                            </div>
                                            <input type="hidden" name="description" id="description-hidden">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="soumis_tva" name="soumis_tva" 
                                                               {{ isset($restoredData['soumis_tva']) && $restoredData['soumis_tva'] ? 'checked' : 'checked' }}>
                                                        <label class="form-check-label" for="soumis_tva">
                                                            Soumis à la TVA
                                                        </label>
                                                    </div>
                                                </div>
        
                                                
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3" id="tva_section">
                                                    <label for="tva_id" class="form-label">TVA</label>
                                                    <select class="form-select" id="tva_id" name="tva_id">
                                                        <option value="">Sélectionnez une TVA</option>
                                                        @foreach($tvas as $tva)
                                                            <option value="{{ $tva->id }}" data-taux="{{ $tva->taux }}"
                                                                    {{ isset($restoredData['tva_id']) && $restoredData['tva_id'] == $tva->id ? 'selected' : '' }} {{ ($tva->est_principal == true && !isset($restoredData['tva_id'])) ? 'selected' : '' }}>
                                                                {{ $tva->nom }} ({{ $tva->taux }}%)
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="montant_ht" class="form-label">Montant HT</label>
                                            <input type="number" step="0.01" class="form-control" id="montant_ht" name="montant_ht" 
                                                           value="{{ $restoredData['montant_ht'] ?? ($commande ? $commande->montant_ht : '') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                               
                                                <div class="mb-3">
                                                    <label for="montant_tva" class="form-label">Montant TVA</label>
                                                    <input type="number" step="0.01" class="form-control" id="montant_tva" name="montant_tva" 
                                                           value="{{ $restoredData['montant_tva'] ?? ($commande ? $commande->montant_tva : '') }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="montant_ttc" class="form-label">Montant TTC</label>
                                            <input type="number" step="0.01" class="form-control" id="montant_ttc" name="montant_ttc" 
                                                   value="{{ $restoredData['montant_ttc'] ?? ($commande ? $commande->montant_ttc : '') }}" required>
                                        </div>
                                        
                                        
                                        </div>

                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('facture.index') }}" class="btn btn-secondary">
                                                <i class="mdi mdi-arrow-left me-1"></i> Annuler
                                            </a>
                                            <button type="button" class="btn btn-info" id="preview-btn">
                                                 Suivant <i class="mdi mdi-arrow-right me-1"></i>
                                            </button>
                                            
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Facture multiple -->
                        @if($type === 'client' && !$commande)
                            <div class="tab-pane" id="facture-multiple">
                                <form action=""  enctype="multipart/form-data">
                                    @csrf
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="mb-3">Sélection du client</h5>
                                            
                                            <div class="mb-3">
                                                <label for="client_id_multiple" class="form-label">Client</label>
                                                <select class="form-select select2" data-toggle="select2" id="client_id_multiple" name="client_id" required>
                                                    <option value="">Sélectionner un client</option>
                                                    
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <h5 class="mb-3">Commandes disponibles</h5>
                                            <div id="commandes-container">
                                                <p class="text-muted">Sélectionnez un client pour voir ses commandes non facturées.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('facture.index') }}" class="btn btn-secondary">
                                                    <i class="mdi mdi-arrow-left me-1"></i> Annuler
                                                </a>
                                                <button type="button" class="btn btn-info" id="preview-multiple-btn">
                                                    Suivant <i class="mdi mdi-arrow-right me-1"></i>
                                                </button>
                                           
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Indicateur de chargement pour la prévisualisation -->
    <div id="loading-preview" class="text-center p-4" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Chargement...</span>
        </div>
        <p class="mt-2 text-muted">Génération du PDF en cours...</p>
    </div>
</div>
@endsection

@section('script')
    @include('components.contact.add_select2_script')

<script>
    initContactsSelect2('#client_id');
    initContactsSelect2('#fournisseur_id');
    initContactsSelect2('#client_id_multiple');
</script>
<script src="{{ asset('assets/js/quill.min.js') }}"></script>

<script>
    // Initialiser l'éditeur Quill avec le contenu de la commande
    var quill = null;
    
    $(document).ready(function() {
        // Initialiser Quill seulement si l'élément existe
        if ($('#description-editor').length > 0) {
            quill = new Quill("#description-editor", {
                theme: "snow",
                modules: {
                    toolbar: [
                        [{font: []}, {size: []}],
                        ["bold", "italic", "underline", "strike"],
                        [{color: []}, {background: []}],
                        [{script: "super"}, {script: "sub"}],
                        [{header: [!1, 1, 2, 3, 4, 5, 6]}, "blockquote", "code-block"],
                        [{list: "ordered"}, {list: "bullet"}, {indent: "-1"}, {indent: "+1"}],
                        ["direction", {align: []}],
                        ["link", "image", "video"],
                        ["clean"]
                    ]
                }
            });

            // Définir le contenu initial si une commande est associée
            @if($commande)
                quill.root.innerHTML = "Facture pour la commande N°{{ $commande->numero_commande }}";
            @elseif(isset($restoredData['description']))
                quill.root.innerHTML = {!! json_encode($restoredData['description']) !!};
            @endif
        }

        // Récupérer la valeur de l'éditeur avant l'envoi du formulaire
        $('form').on('submit', function() {
            if (quill && quill.root) {
                var descriptionContent = quill.root.innerHTML;
                $('#description-hidden').val(descriptionContent);
            }
        });
    });
</script>

<script>
$(document).ready(function() {
    // Gestion de la TVA
    $('#soumis_tva').change(function() {
        if ($(this).is(':checked')) {
            $('#tva_section').show();
            calculerTTC();
        } else {
            $('#tva_section').hide();
            $('#montant_tva').val(0);
            $('#montant_ttc').val($('#montant_ht').val());
        }
    });

    $('#tva_id').change(function() {
        calculerTTC();
    });

    $('#montant_ht').on('input', function() {
        calculerTTC();
    });

    $('#montant_ttc').on('input', function() {
        calculerHT();
    });
    function calculerHT() {
        var montantTTC = parseFloat($('#montant_ttc').val()) || 0;
        var tvaId = $('#tva_id').val();
        var tauxTVA = 0;

        if (tvaId) {
            var option = $('#tva_id option:selected');
            tauxTVA = parseFloat(option.data('taux')) || 0;
        }
        var montantTVA = montantTTC * (tauxTVA / 100);
        var montantHT = montantTTC - montantTVA;
        $('#montant_ht').val(montantHT.toFixed(2));
        $('#montant_tva').val(montantTVA.toFixed(2));

    }

    function calculerTTC() {
        var montantHT = parseFloat($('#montant_ht').val()) || 0;
        var tvaId = $('#tva_id').val();
        var tauxTVA = 0;

        if (tvaId) {
            var option = $('#tva_id option:selected');
            tauxTVA = parseFloat(option.data('taux')) || 0;
        }

        var montantTVA = montantHT * (tauxTVA / 100);
        var montantTTC = montantHT + montantTVA;

        $('#montant_tva').val(montantTVA.toFixed(2));
        $('#montant_ttc').val(montantTTC.toFixed(2));
    }

    // Calcul automatique des montants (ancien code pour compatibilité)
    $('#montant_ht, #montant_tva').on('input', function() {
        if (!$('#soumis_tva').is(':checked')) {
        let ht = parseFloat($('#montant_ht').val()) || 0;
        let tva = parseFloat($('#montant_tva').val()) || 0;
        $('#montant_ttc').val((ht + tva).toFixed(2));
        }
    });

    // Charger les commandes non facturées pour un client
    $('#client_id_multiple').on('change', function() {
        let clientId = $(this).val();
        if (clientId) {
            $.get(`/api/factures/commandes-non-facturees/${clientId}`, function(data) {
                let html = '';
                if (data.length > 0) {
                    html = '<div class="list-group">';
                    data.forEach(function(commande) {
                        html += `
                            <label class="list-group-item">
                                <input class="form-check-input me-1" type="checkbox" name="commandes[]" value="${commande.id}">
                                Commande N°${commande.numero_commande} - ${commande.montant_ttc} €
                                <small class="text-muted d-block">${commande.date_commande}</small>
                            </label>
                        `;
                    });
                    html += '</div>';
                    $('#btn-create-multiple').prop('disabled', false);
                } else {
                    html = '<p class="text-muted">Aucune commande non facturée pour ce client.</p>';
                    $('#btn-create-multiple').prop('disabled', true);
                }
                $('#commandes-container').html(html);
            });
        } else {
            $('#commandes-container').html('<p class="text-muted">Sélectionnez un client pour voir ses commandes non facturées.</p>');
            $('#btn-create-multiple').prop('disabled', true);
        }
    });

    // Initialisation
    calculerTTC();

    // Gestion de la prévisualisation PDF
    $('#preview-btn').click(function(e) {
        previewFacture('simple', e.target);
    });

    // Gestion de la prévisualisation PDF pour factures multiples
    $('#preview-multiple-btn').click(function(e) {
        previewFacture('multiple', e.target);
    });

    // Définir la fonction previewFacture dans le scope document.ready
    window.previewFacture = function(type, buttonElement) {
        var formData = new FormData();
        
        // Ajouter le token CSRF
        formData.append('_token', $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val());
        formData.append('type', 'client'); // Les factures multiples sont toujours pour des clients
        formData.append('preview', '1');
        formData.append('preview_type', type);
        
        if (type === 'simple') {
            // Récupérer la valeur de l'éditeur Quill de manière sécurisée
            var descriptionContent = '';
            if (typeof quill !== 'undefined' && quill && quill.root) {
                descriptionContent = quill.root.innerHTML;
            } else {
                // Fallback si Quill n'est pas disponible
                descriptionContent = $('#description-hidden').val() || '';
            }
            $('#description-hidden').val(descriptionContent);
            
            // Ajouter tous les champs requis manuellement
            formData.append('date', $('#date').val());
            formData.append('montant_ht', $('#montant_ht').val() || '0');
            formData.append('montant_tva', $('#montant_tva').val() || '0');
            formData.append('montant_ttc', $('#montant_ttc').val() || '0');
            formData.append('description', descriptionContent);
            formData.append('client_id', $('#client_id').val());
            
            // Ajouter les champs TVA
            if ($('#soumis_tva').is(':checked')) {
                formData.append('soumis_tva', '1');
                formData.append('tva_id', $('#tva_id').val() || '');
            }
        } else {
            // Pour les factures multiples
            formData.append('client_id', $('#client_id_multiple').val());
            formData.append('date', new Date().toISOString().split('T')[0]);
            
            // Récupérer les commandes sélectionnées
            var commandesSelectionnees = [];
            $('input[name="commandes[]"]:checked').each(function() {
                commandesSelectionnees.push($(this).val());
            });
            formData.append('commandes', JSON.stringify(commandesSelectionnees));
        }

        // Validation côté client
        if (type === 'simple') {
            var montantHT = $('#montant_ht').val();
            var montantTTC = $('#montant_ttc').val();
            var date = $('#date').val();
            var clientId = $('#client_id').val();

            if (!montantHT || montantHT <= 0) {
                alert('Veuillez saisir un montant HT valide');
                return;
            }

            if (!montantTTC || montantTTC <= 0) {
                alert('Veuillez saisir un montant TTC valide');
                return;
            }

            if (!date) {
                alert('Veuillez saisir une date');
                return;
            }

            if (!clientId) {
                alert('Veuillez sélectionner un client');
                return;
            }
        } else {
            var clientId = $('#client_id_multiple').val();
            var commandesSelectionnees = $('input[name="commandes[]"]:checked').length;

            if (!clientId) {
                alert('Veuillez sélectionner un client');
                return;
            }

            if (commandesSelectionnees === 0) {
                alert('Veuillez sélectionner au moins une commande');
                return;
            }
        }

        // Désactiver le bouton pendant le chargement
        var $btn = $(buttonElement);
        var originalText = $btn.html();
        $btn.html('<i class="mdi mdi-loading mdi-spin me-1"></i> Génération...');
        $btn.prop('disabled', true);

        // Afficher l'indicateur de chargement
        $('#loading-preview').show();
        
        $.ajax({
            url: '{{ route("facture.preview") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val()
            },
            success: function(response) {
                if (response.success) {
                    // Rediriger vers la page de prévisualisation
                    window.location.href = response.preview_url;
                } else {
                    alert('Erreur lors de la génération du PDF : ' + response.message);
                }
            },
            error: function(xhr) {
                console.log('Erreur AJAX:', xhr);
                if (xhr.responseJSON) {
                    alert('Erreur lors de la génération du PDF : ' + xhr.responseJSON.message);
                } else {
                    alert('Erreur lors de la génération du PDF');
                }
            },
            complete: function() {
                // Réactiver le bouton
                $btn.html(originalText);
                $btn.prop('disabled', false);
                // Cacher l'indicateur de chargement
                $('#loading-preview').hide();
            }
        });
    };

    // Restaurer les données de prévisualisation si disponibles
    @if(isset($restoredData))
        // Restaurer les sélecteurs après un délai pour laisser Select2 s'initialiser
        setTimeout(function() {
            @if(isset($restoredData['client_id']))
                if ($('#client_id').length > 0) {
                    $('#client_id').val('{{ $restoredData['client_id'] }}').trigger('change.select2');
                }
            @endif
            
            @if(isset($restoredData['fournisseur_id']))
                if ($('#fournisseur_id').length > 0) {
                    $('#fournisseur_id').val('{{ $restoredData['fournisseur_id'] }}').trigger('change.select2');
                }
            @endif
        }, 1000); // Délai plus long pour s'assurer que Select2 est complètement initialisé
        
        // Afficher un message informatif
        if (typeof toastr !== 'undefined') {
            toastr.info('Vos données de prévisualisation ont été restaurées. Vous pouvez les modifier si nécessaire.');
        } else {
            // Fallback si toastr n'est pas disponible
            $('<div class="alert alert-info alert-dismissible fade show" role="alert">' +
              '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
              '<strong>Restauration :</strong> Vos données de prévisualisation ont été restaurées. Vous pouvez les modifier si nécessaire.' +
              '</div>').insertAfter('.page-title-box');
        }
    @endif
});
</script>
@endsection 