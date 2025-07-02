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
                                    <i class="mdi mdi-file-multiple me-1"></i> Facture multiple
                                </a>
                            </li>
                        </ul>
                    @endif

                    <div class="tab-content">
                        <!-- Facture simple -->
                        <div class="tab-pane show active" id="facture-simple">
                            <form action="{{ route('facture.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="type" value="{{ $type }}">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="numero" class="form-label">Numéro de facture</label>
                                                    <input type="text" class="form-control" id="numero" name="numero" 
                                                           value="{{ $prochain_numero}}" >   
                                                </div>
        
                                                
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="date" class="form-label">Date de facture</label>
                                                    <input type="date" class="form-control" id="date" name="date" 
                                                           value="{{ date('Y-m-d') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        

                                        @if($type === 'client')
                                            <div class="mb-3">
                                                <label for="client_id" class="form-label">Client</label>
                                                <select class=" form-control select2" data-toggle="select2" required id="client_id" name="client_id" required>
                                                    <option value="">Sélectionner un client</option>
                                                   
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
                                                <input type="text" class="form-control" id="numero_origine" name="numero_origine">
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
                                                        <input class="form-check-input" type="checkbox" id="soumis_tva" name="soumis_tva" checked>
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
                                                            <option value="{{ $tva->id }}" data-taux="{{ $tva->taux }}">
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
                                                           value="{{ $commande ? $commande->montant_ht : '' }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="montant_ttc" class="form-label">Montant TTC</label>
                                                    <input type="number" step="0.01" class="form-control" id="montant_ttc" name="montant_ttc" 
                                                           value="{{ $commande ? $commande->montant_ttc : '' }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        

                                        <div class="mb-3">
                                            <label for="montant_tva" class="form-label">Montant TVA</label>
                                            <input type="number" step="0.01" class="form-control" id="montant_tva" name="montant_tva" 
                                                   value="{{ $commande ? $commande->montant_tva : '0.00' }}" readonly>
                                        </div>
                                        
                                    </div>
                                    
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('facture.index') }}" class="btn btn-secondary">
                                                <i class="mdi mdi-arrow-left me-1"></i> Annuler
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="mdi mdi-content-save me-1"></i> Créer la facture
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Facture multiple -->
                        @if($type === 'client' && !$commande)
                            <div class="tab-pane" id="facture-multiple">
                                <form action="{{ route('facture.create-multiple') }}" method="POST">
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
                                                <button type="submit" class="btn btn-primary" id="btn-create-multiple" disabled>
                                                    <i class="mdi mdi-file-multiple me-1"></i> Créer la facture multiple
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
    var quill = new Quill("#description-editor", {
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
    @endif

    // Récupérer la valeur de l'éditeur avant l'envoi du formulaire
    $('form').on('submit', function() {
        var descriptionContent = quill.root.innerHTML;
        $('#description-hidden').val(descriptionContent);
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
});
</script>
@endsection 