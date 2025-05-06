@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
@endsection

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('commande.index') }}">Commandes</a></li>
                            <li class="breadcrumb-item active">Ajouter</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Ajouter une commande</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('commande.store') }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Client/Prospect</label>
                                    <select class="form-select" name="client_prospect_id" required>
                                        <option value="">Sélectionner un client</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">
                                                @if($client->type == 'individu')
                                                    {{ $client->individu->nom }} {{ $client->individu->prenom }}
                                                @else
                                                    {{ $client->entite->raison_sociale }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Commercial</label>
                                    <select class="form-select" name="collaborateur_id">
                                        <option value="">Sélectionner un commercial</option>
                                        @foreach($collaborateurs as $collaborateur)
                                            <option value="{{ $collaborateur->id }}">
                                                {{ $collaborateur->individu->nom }} {{ $collaborateur->individu->prenom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nom de la commande</label>
                                    <input type="text" class="form-control" name="nom_commande" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Date de commande</label>
                                    <input type="date" class="form-control" name="date_commande" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Date de réalisation prévue</label>
                                    <input type="date" class="form-control" name="date_realisation_prevue">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Mode de paiement</label>
                                    <select class="form-select" name="mode_paiement">
                                        <option value="comptant">Comptant</option>
                                        <option value="30_jours">30 jours</option>
                                        <option value="45_jours">45 jours</option>
                                        <option value="60_jours">60 jours</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="card border">
                                        <div class="card-body">
                                            <h5 class="card-title">Produits</h5>
                                            <div class="table-responsive">
                                                <table class="table table-centered table-nowrap mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Produit</th>
                                                            <th>Quantité</th>
                                                            <th>Prix unitaire</th>
                                                            <th>TVA</th>
                                                            <th>Remise</th>
                                                            <th>Total HT</th>
                                                            <th>Total TTC</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="produits-container">
                                                        <!-- Les lignes de produits seront ajoutées ici -->
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="8">
                                                                <button type="button" class="btn btn-info btn-sm" id="ajouter-produit">
                                                                    <i class="mdi mdi-plus-circle"></i> Ajouter un produit
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-end">
                                    <a href="{{ route('commande.index') }}" class="btn btn-light me-2">Annuler</a>
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Script pour la gestion dynamique des produits
        let produits = @json($produits);
        let rowCount = 0;

        function addProductRow() {
            let template = `
                <tr>
                    <td>
                        <select class="form-select" name="produits[${rowCount}][id]" required onchange="updatePrices(this)">
                            <option value="">Sélectionner un produit</option>
                            ${produits.map(p => `<option value="${p.id}" data-prix="${p.prix_unitaire}" data-tva="${p.taux_tva}">${p.nom}</option>`).join('')}
                        </select>
                    </td>
                    <td><input type="number" class="form-control quantite" name="produits[${rowCount}][quantite]" value="1" min="1" onchange="calculateTotal(this)"></td>
                    <td><input type="number" step="0.01" class="form-control prix" name="produits[${rowCount}][prix_unitaire]" readonly></td>
                    <td><input type="number" step="0.01" class="form-control tva" name="produits[${rowCount}][taux_tva]" readonly></td>
                    <td><input type="number" step="0.01" class="form-control remise" name="produits[${rowCount}][remise]" value="0" min="0" max="100" onchange="calculateTotal(this)"></td>
                    <td><input type="number" step="0.01" class="form-control total-ht" name="produits[${rowCount}][montant_ht]" readonly></td>
                    <td><input type="number" step="0.01" class="form-control total-ttc" name="produits[${rowCount}][montant_ttc]" readonly></td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </td>
                </tr>
            `;
            
            $('#produits-container').append(template);
            rowCount++;
        }

        function updatePrices(select) {
            let row = $(select).closest('tr');
            let option = $(select).find(':selected');
            
            row.find('.prix').val(option.data('prix'));
            row.find('.tva').val(option.data('tva'));
            
            calculateTotal(select);
        }

        function calculateTotal(element) {
            let row = $(element).closest('tr');
            let quantite = parseFloat(row.find('.quantite').val());
            let prix = parseFloat(row.find('.prix').val());
            let tva = parseFloat(row.find('.tva').val());
            let remise = parseFloat(row.find('.remise').val());
            
            let montantHT = quantite * prix;
            if (remise > 0) {
                montantHT = montantHT * (1 - (remise/100));
            }
            
            let montantTTC = montantHT * (1 + (tva/100));
            
            row.find('.total-ht').val(montantHT.toFixed(2));
            row.find('.total-ttc').val(montantTTC.toFixed(2));
        }

        function removeRow(button) {
            $(button).closest('tr').remove();
        }

        $('#ajouter-produit').click(function() {
            addProductRow();
        });

        // Ajouter une première ligne au chargement
        $(document).ready(function() {
            addProductRow();
        });
    </script>
@endsection 