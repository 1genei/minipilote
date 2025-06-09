@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
@endsection

@section('title', 'Modification devis')

@section('content')
    <div class="content">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('devis.index') }}">Devis</a></li>
                            <li class="breadcrumb-item active">Modifier</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Modifier le devis</h4>
                </div>
            </div>

            <div class="col-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-sm-2">
                                <a href="{{ route('devis.index') }}" type="button" class="btn btn-outline-primary"><i
                                        class="uil-arrow-left"></i>
                                    Devis</a>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                @if (session('message'))
                                    <div class="alert alert-success text-secondary alert-dismissible">
                                        <i class="dripicons-checkmark me-2"></i>
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <a href="#" class="alert-link"><strong> {{ session('message') }}</strong></a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <form action="{{ route('devis.update', Crypt::encrypt($devis->id)) }}" method="post" id="form_devis">
                            @csrf
                            @method('POST')
                            
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="col-lg-12 col-md-12 col-sm-12" id="palier">
                                        <div class="panel panel-pink m-t-15">
                                            <div class="panel-heading"><strong>Devis </strong></div>
                                            <div class="panel-body">
                                                <br>
                                                <div class="row">
                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <label for="numero_devis" class="form-label">
                                                                Numéro du devis <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="number" id="numero_devis" name="numero_devis"
                                                                value="{{ $devis->numero_devis }}" class="form-control"
                                                                style="font-size: 1.3rem;color: #772e7b;" required>
                                                            @if ($errors->has('numero_devis'))
                                                                <br>
                                                                <div class="alert alert-warning text-secondary" role="alert">
                                                                    <button type="button" class="btn-close btn-close-white"
                                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                                    <strong>{{ $errors->first('numero_devis') }}</strong>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="nom_devis" class="form-label">
                                                                Nom du devis
                                                            </label>
                                                            <input type="text" id="nom_devis" name="nom_devis"
                                                                value="{{ $devis->nom_devis }}" class="form-control"
                                                                style="font-size: 1.3rem;color: #772e7b;">
                                                            @if ($errors->has('nom_devis'))
                                                                <br>
                                                                <div class="alert alert-warning text-secondary" role="alert">
                                                                    <button type="button" class="btn-close btn-close-white"
                                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                                    <strong>{{ $errors->first('nom_devis') }}</strong>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label">Client/Prospect <span class="text-danger">*</span>
                                                                <span class="badge bg-danger">
                                                                    {{ $devis->client_prospect()?->type == 'individu' ? $devis->client_prospect()?->individu->nom . ' ' . $devis->client_prospect()?->individu->prenom : $devis->client_prospect()?->entite->raison_sociale }}
                                                                </span>
                                                            </label>
                                                            <select class="form-control select2" data-toggle="select2" name="client_prospect_id" id="client_prospect_id" required>
                                                                <option value="{{ $devis->client_prospect_id }}">{{ $devis->client_prospect()?->nom . ' ' . $devis->client_prospect()?->prenom }}</option>
                                                                <option value="">Sélectionnez un client/prospect</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="add-contact" class="form-label">.</label> <br>
                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                                data-bs-target="#add-contact">
                                                                <i class="mdi mdi-plus-circle me-1"></i> Ajouter un nouveau contact
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row mb-3" style="margin-top: 20px; background-color: #bacbdb; padding: 10px;">
                                                <div class="col-md-12">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="no_tva" name="no_tva"
                                                            {{ $devis->sans_tva ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="no_tva">Ne pas facturer la TVA</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="filtres mt-5">
                                <div class="row">
                                    <div class="col-auto">
                                        <div class="mb-3">
                                            <label for="categorie" class="form-label">
                                                Catégorie
                                            </label>
                                            <select name="categorie" id="categorie" class="filtrer form-control select2"
                                                data-toggle="select2">
                                                <option value="">Sélectionnez la catégorie</option>
                                                @foreach ($categories as $categorie)
                                                    <option value="{{ $categorie->id }}">
                                                        {{ $categorie->nom }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="mb-3">
                                            <label for="voiture" class="form-label">
                                                Voiture
                                            </label>
                                            <select name="voiture" id="voiture" class="filtrer form-control select2"
                                                data-toggle="select2">
                                                <option value="">Sélectionnez la voiture</option>
                                                @foreach ($voitures as $voiture)
                                                    <option value="{{ $voiture->id }}">
                                                        {{ $voiture->nom }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="mb-3">
                                            <label for="circuit" class="form-label">
                                                Circuit
                                            </label>
                                            <select name="circuit" id="circuit" class="filtrer form-control select2"
                                                data-toggle="select2">
                                                <option value="">Sélectionnez le circuit</option>
                                                @foreach ($circuits as $circuit)
                                                    <option value="{{ $circuit->id }}">
                                                        {{ $circuit->nom }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-auto">
                                        <div class="mb-3">
                                            <label for="produit" class="form-label">
                                                Produit
                                            </label>
                                            <span id="nb_produit"></span>
                                            <select name="produit" id="produit" class="form-control select2"
                                                data-toggle="select2">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="mb-3 mt-3">
                                            <button class="btn btn-warning add_field_button" style="margin-left: 53px;">
                                                Ajouter au devis
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="row">
                                <div class="col-lg-12">
                                    <div class="input_fields_wrap">
                                        @foreach(json_decode($devis->palier) as $key => $ligne)
                                            <div class="row gy-2 gx-2 align-items-center field{{ $key + 1 }}">
                                                <div class="col-4">
                                                    <label for="produit{{ $key + 1 }}">Produit: </label>
                                                    <select class="form-control select2 liste_produits select_produit actualiser" 
                                                        id="produit{{ $key + 1 }}" name="produit{{ $key + 1 }}">
                                                        <option></option>
                                                        @foreach($produits as $produit)
                                                            <option value="{{ $produit->id }}" 
                                                                {{ $produit->id == $ligne[0] ? 'selected' : '' }}>
                                                                {{ $produit->nom }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-1">
                                                    <label for="quantite{{ $key + 1 }}">Quantité: </label>
                                                    <input class="form-control quantite" type="number" min="1" 
                                                        value="{{ $ligne[1] }}" id="quantite{{ $key + 1 }}" 
                                                        required name="quantite{{ $key + 1 }}"/>
                                                </div>
                                                <div class="col-1">
                                                    <label for="prix_ht{{ $key + 1 }}">Prix HT (€): </label>
                                                    <input class="form-control prix_ht actualiser" type="number" min="1" 
                                                        step="0.01" value="{{ $ligne[2] }}" required 
                                                        id="prix_ht{{ $key + 1 }}" name="prix_ht{{ $key + 1 }}">
                                                </div>
                                                <div class="col-1">
                                                    <label for="tva{{ $key + 1 }}">TVA: </label>
                                                    <select class="form-select liste_tvas tva actualiser" 
                                                        id="tva{{ $key + 1 }}" name="tva{{ $key + 1 }}">
                                                        <option></option>
                                                        @foreach($tvas as $tva)
                                                            <option value="{{ $tva->id }}" 
                                                                {{ $tva->id == $ligne[3] ? 'selected' : '' }}>
                                                                {{ $tva->nom }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-1">
                                                    <label for="type_reduction{{ $key + 1 }}">Réduction: </label>
                                                    <select class="form-select type_reduction actualiser" 
                                                        id="type_reduction{{ $key + 1 }}" 
                                                        name="type_reduction{{ $key + 1 }}">
                                                        <option></option>
                                                        <option value="pourcentage" 
                                                            {{ $ligne[4] == 'pourcentage' ? 'selected' : '' }}>%</option>
                                                        <option value="montant" 
                                                            {{ $ligne[4] == 'montant' ? 'selected' : '' }}>EUR</option>
                                                    </select>
                                                </div>
                                                <div class="col-1">
                                                    <label for="reduction{{ $key + 1 }}"> </label>
                                                    <input class="form-control reduction actualiser" type="number" 
                                                        step="0.01" min="0" value="{{ $ligne[5] }}" 
                                                        id="reduction{{ $key + 1 }}" 
                                                        name="reduction{{ $key + 1 }}" 
                                                        {{ empty($ligne[4]) ? 'readonly' : '' }}>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="remove_field btn btn-danger btn-sm">
                                                        <i class="mdi mdi-delete"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div> --}}

                            <hr>
                            <div class="input_fields_wrap" style="margin-top: 20px; margin-bottom: 20px; background-color: #f8f9fa;">
                                @php
                                    $y = 0;
                                @endphp
                                @foreach($devis->produits as $produit)
                                    @php 
                                        $y = $loop->iteration;    
                                    @endphp

                                    <div class="row gy-2 gx-2 align-items-center field{{$y}}"> 
                                        <div class="col-4">
                                            <label for="produit{{$y}}">Produit: </label> 
                                            <select class="form-control select2 liste_produits select_produit actualiser" id="produit{{$y}}" value="{{$produit->id}}" name="produit{{$y}}">
                                                @foreach($produits as $p)
                                                    <option value="{{ $p->id }}" {{ $produit->id == $p->id ? 'selected' : '' }}>
                                                        {{ $p->nom }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-1">
                                            <label for="quantite{{$y}}">Quantité: </label>
                                            <input class="form-control quantite " type="number"  min="1" id="quantite{{$y}}" value="{{ $produit->pivot->quantite }}" required name="quantite{{$y}}"/>
                                        </div>
                                        <div class="col-1">
                                            <label for="prix_ht{{$y}}">Prix HT (€): </label>
                                            <input class="form-control prix_ht actualiser" type="number" min="1" step="0.01" value="{{ $produit->pivot->prix_unitaire }}" required id="prix_ht{{$y}}" name="prix_ht{{$y}}" >
                                        </div>
                                        <div class="col-1">
                                            <label for="tva{{$y}}">Tva: </label>
                                            <select class="form-select liste_tvas tva actualiser" width="80px" id="tva{{$y}}" value="{{ $produit->pivot->taux_tva }}" name="tva{{$y}}">
                                                @foreach($tvas as $tva)
                                                    <option value="{{ $tva->id }}" {{ $produit->pivot->taux_tva == $tva->taux ? 'selected' : '' }}>
                                                        {{ $tva->taux }}%
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div> 
                                        <div class="col-1">
                                            <label for="type_reduction{{$y}}">Réduction: </label>
                                            <select class="form-select type_reduction actualiser" id="type_reduction{{$y}}" value="{{ $produit->pivot->taux_remise ? 'pourcentage' : 'montant' }}" name="type_reduction{{$y}}">
                                                <option value=""></option>
                                                <option value="pourcentage" {{ $produit->pivot->taux_remise ? 'selected' : '' }}>%</option>
                                                <option value="montant" {{ $produit->pivot->remise && !$produit->pivot->taux_remise ? 'selected' : '' }}>EUR</option>
                                            </select>
                                        </div>
                                        <div class="col-1">
                                            <label for="reduction{{$y}}"> </label>
                                            <input class="form-control reduction actualiser" type="number" step="0.01" min="0" id="reduction{{$y}}" value="{{ $produit->pivot->taux_remise ?: $produit->pivot->remise }}" name="reduction{{$y}}" @if(!$produit->pivot->taux_remise) readonly @endif >
                                        </div>
                                      
                                        <div class="col-auto">
                                            <a href="#" class="remove_field btn btn-danger btn-sm">
                                                <i class="mdi mdi-delete"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach


                            
                            </div>


                            <div class="col-lg-12 mt-5">
                                <button type="button" id="actualiser" class="btn btn-info">
                                    <i class="mdi mdi-reload me-1"></i> <span>Actualiser</span>
                                </button>

                                <div class="border p-3 mt-4 mt-lg-0 rounded">
                                    <h4 class="header-title mb-3">Résumé du devis</h4>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-centered">
                                            <thead>
                                                <tr>
                                                    <th class="text-start">Produit</th>
                                                    <th class="text-start" style="width: 100px;">Quantité</th>
                                                    <th class="text-start" style="width: 120px;">Montant HT</th>
                                                    <th class="text-start" style="width: 120px;">Réduction</th>
                                                    <th class="text-start" style="width: 120px;">Montant TTC</th>
                                                    <th class="text-start" style="width: 100px;">Montant TVA</th>
                                                </tr>
                                            </thead>
                                            <tbody class="resume_devis">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-auto">
                                        <label for="type_reduction_globale">Réduction: </label>
                                        <select class="form-select type_reduction_globale" id="type_reduction_globale"
                                            name="type_reduction_globale">
                                            <option></option>
                                            <option value="pourcentage" {{ $devis->type_remise == 'pourcentage' ? 'selected' : '' }}>%</option>
                                            <option value="montant" {{ $devis->type_remise == 'montant' ? 'selected' : '' }}>EUR</option>
                                        </select>
                                    </div>

                                    <div class="col-auto">
                                        <label for="reduction_globale"> </label>
                                        <input class="form-control reduction_total" type="number" step="0.01" min="0"
                                            value="{{ $devis->remise }}" id="reduction_globale" name="reduction_globale"
                                            {{ empty($devis->type_remise) ? 'readonly' : '' }}>
                                    </div>

                                    <div class="col-auto">
                                        <label for="reduction_globale"> </label>
                                        <button class="input-group-text btn-light" id="appliquer_reduction"
                                            type="button">Appliquer</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="modal-footer" style="justify-content:flex-start;">
                                    <button type="submit" id="enregistrer" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.contact.add_select2_script')
    @include('components.contact.quick_add_modal')
@endsection

@section('script')
    @include('components.contact.quick_add_modal_script')
    <script>
        initContactsSelect2('#client_prospect_id');
        var client_prospect_id = "{{ $devis->client_prospect_id }}";
        $('#client_prospect_id').val(client_prospect_id).trigger('change');
    </script>

    <script>
        var produits = @json($produits);
        var tab_produits = [];
        var liste_produits = "";
        var y = {{ $y }};
        
        $("#produit").empty();
        produits.forEach(function(produit) {
            $("#produit").append('<option value="' + produit.id + '">' + produit.nom + '</option>');
            liste_produits += '<option value="' + produit.id + '">' + produit.nom + '</option>';
            tab_produits[produit.id] = produit;
        });
        
        var nb_produit = produits.length;
        $('#nb_produit').html('<span class="text-danger">'+nb_produit+' produits trouvés</span>');

        $(".filtrer").change(function(e) {
            e.preventDefault();
            
            $.ajax({
                url: '/produits/rechercher',
                type: 'GET',
                data: {
                    categorie_id: $('#categorie').val(),
                    voiture_id: $('#voiture').val(),
                    circuit_id: $('#circuit').val()
                },
                success: function(response) {
                    var nb_produit = response.length;
                    $('#nb_produit').html('<span class="text-danger">'+nb_produit+' produits trouvés</span>');
                    tab_produits = [];
                    liste_produits = "";
                    
                    $("#produit").empty();
                    response.forEach(function(produit) {
                        $("#produit").append('<option value="' + produit.id + '">' + produit.nom + '</option>');
                        liste_produits += '<option value="' + produit.id + '">' + produit.nom + '</option>';
                        tab_produits[produit.id] = produit;
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Une erreur est survenue : " + status + " " + error);
                }
            });
        });

        var tvas = @json($tvas);
        var tab_tvas = {};
        var resume_devis = [];
        
        var liste_tvas = "";
        tvas.forEach(element => {
            liste_tvas += '<option value="' + element.id + '">' + element.nom + '</option>';
            tab_tvas[element.id] = element.taux;
        });
        
        var tab_produits_init = tab_produits;
        
        $(document).on('change', '.select_produit', function() {
            var id = $(this).val();
            var prix_ht = tab_produits[id].prix_vente_ht;
            var tva = tab_produits[id].tva_id;
            
            $(this).parent().parent().find('.prix_ht').val(prix_ht);
            $(this).parent().parent().find('.tva option[value="'+tva+'"]').attr("selected",true);
        });
        
        $(document).ready(function() {
            var max_produits = 30;
            var wrapper = $(".input_fields_wrap");
            var add_button = $(".add_field_button");
            
            $(add_button).click(function(e) {
                e.preventDefault();
                if (y < max_produits) {
                    var nom_produit = $("#produit").val();
                    
                    if(nom_produit != "" && nom_produit !== undefined) {
                        y++;
                        
                        var fieldHTML = `
                            <div class="row gy-2 gx-2 align-items-center field${y}">
                                <div class="col-4">
                                    <label for="produit${y}">Produit: </label>
                                    <select class="form-control select2 liste_produits select_produit actualiser"
                                        id="produit${y}" name="produit${y}">
                                        <option></option>
                                        ${liste_produits}
                                    </select>
                                </div>
                                <div class="col-1">
                                    <label for="quantite${y}">Quantité: </label>
                                    <input class="form-control quantite" type="number" min="1" value="1"
                                        id="quantite${y}" required name="quantite${y}"/>
                                </div>
                                <div class="col-1">
                                    <label for="prix_ht${y}">Prix HT (€): </label>
                                    <input class="form-control prix_ht actualiser" type="number" min="1"
                                        step="0.01" value="${tab_produits[nom_produit].prix_vente_ht}"
                                        required id="prix_ht${y}" name="prix_ht${y}">
                                </div>
                                <div class="col-1">
                                    <label for="tva${y}">TVA: </label>
                                    <select class="form-select liste_tvas tva actualiser"
                                        id="tva${y}" name="tva${y}">
                                        <option></option>
                                        ${liste_tvas}
                                    </select>
                                </div>
                                <div class="col-1">
                                    <label for="type_reduction${y}">Réduction: </label>
                                    <select class="form-select type_reduction actualiser"
                                        id="type_reduction${y}" name="type_reduction${y}">
                                        <option></option>
                                        <option value="pourcentage">%</option>
                                        <option value="montant">EUR</option>
                                    </select>
                                </div>
                                <div class="col-1">
                                    <label for="reduction${y}"> </label>
                                    <input class="form-control reduction actualiser" type="number"
                                        step="0.01" min="0" id="reduction${y}"
                                        name="reduction${y}" readonly>
                                </div>
                                <div class="col-auto">
                                    <a href="#" class="remove_field btn btn-danger btn-sm">
                                        <i class="mdi mdi-delete"></i>
                                    </a>
                                </div>
                            </div>`;
                
                        $(wrapper).append(fieldHTML);
                        
                        $(`#produit${y}`).select2({
                            placeholder: "Sélectionnez un produit",
                            allowClear: true,
                            width: '100%'
                        });
                        
                        $(`#produit${y}`).val(nom_produit).trigger('change');
                        
                        $("#quantite" + y).val(1);
                        $("#prix_ht" + y).val(tab_produits[nom_produit].prix_vente_ht);
                        $("#tva" + y + ' option[value="'+tab_produits[nom_produit].tva_id+'"]').attr("selected",true);
                        
                        $('#actualiser').click();
                    }
                } else {
                    Swal.fire(
                        'Ajout impossible!',
                        'Le maximum de produits est atteint!',
                        'error'
                    );
                }
            });

            $(wrapper).on("click", ".remove_field", function(e) {
                e.preventDefault();
                $(this).parent().parent('div').remove();
                $('#actualiser').click();
            });
        });
        
        $('.input_fields_wrap').on('change keyup focusout', '.actualiser', function() {
            $('#actualiser').click();
        });
        
        $('#actualiser').click(function(e) {
            e.preventDefault();
            
            resume_devis = [];
            var i = 1;
            prix_ttc_total = 0;
            prix_ht_total = 0;
            prix_ht_reduction = 0;
            montant_tva_total = 0;
            montant_reduction_total = 0;
            montant_reduction_globale = 0;
            montant_reduction = 0;
            var sans_tva = $("#no_tva").is(':checked');
            
            while (i <= y) {
                if($("#produit" + i).val() != undefined) {
                    quantite = $("#quantite" + i).val();
                    prix_ht = quantite * $("#prix_ht" + i).val();
                    nom_produit = $("#produit" + i).val();
                    tva_id = $("#tva" + i).val();
                    tva = tab_tvas[tva_id];
                    
                    var type_reduction = $("#type_reduction"+i).val();
                    var reduction = $("#reduction"+i).val();
                    
                    if(type_reduction == "pourcentage") {
                        montant_reduction = prix_ht * reduction / 100;
                    } else if(type_reduction == "montant") {
                        montant_reduction = parseFloat(reduction);
                    }
                    
                    montant_reduction_total += montant_reduction;
                    prix_ht_reduction = prix_ht - montant_reduction;
                    
                    if(sans_tva) {
                        prix_ttc = prix_ht_reduction;
                        montant_tva = 0;
                    } else {
                        prix_ttc = prix_ht_reduction * (1 + tva / 100);
                        montant_tva = prix_ttc - prix_ht_reduction;
                    }
                    
                    prix_ttc_total += parseFloat(prix_ttc);
                    prix_ht_total += parseFloat(prix_ht_reduction);
                    montant_tva_total += parseFloat(montant_tva);
                    
                    if (nom_produit != "" && tab_produits[nom_produit] !== undefined) {
                        resume_devis[i] = `
                            <tr>
                                <td>${tab_produits[nom_produit].nom}</td>
                                <td>${quantite}</td>
                                <td>${prix_ht.toFixed(2)}</td>
                                <td class="text-danger">${montant_reduction.toFixed(2)}</td>
                                <td>${prix_ttc.toFixed(2)}</td>
                                <td>${montant_tva.toFixed(2)}</td>
                            </tr>`;
                    }
                    
                    montant_reduction = 0;
                }
                i++;
            }
            
            if(!isNaN(prix_ttc_total)) {
                net_a_payer = prix_ttc_total;
                
                resume_devis.push(`
                    <tr style="background-color: #f1f3fa; font-weight: bold;">
                        <td>Total :</td>
                        <td></td>
                        <td class="total_ttc">${prix_ht_total.toFixed(2)}</td>
                        <td class="text-danger">${montant_reduction_total.toFixed(2)}</td>
                        <td class="total_ht">${prix_ttc_total.toFixed(2)}</td>
                        <td>${montant_tva_total.toFixed(2)}</td>
                    </tr>
                    <tr style="background-color: #f1f3fa; font-weight: bold;">
                        <td>Réduction totale sur HT :</td>
                        <td class="text-danger total_reduction" colspan="5"></td>
                    </tr>
                    <tr style="background-color: #f1f3fa; font-weight: bold; border:2px solid #ff5b5b">
                        <td>NET À PAYER :</td>
                        <td class="net_a_payer" colspan="5">${net_a_payer.toFixed(2)} €</td>
                    </tr>`);
                
                $('.resume_devis').html(resume_devis.join(""));
            }
            
            $('#appliquer_reduction').click();
        });
        
        $(document).on('change', '.type_reduction', function() {
            var id = $(this).attr('id');
            var num = id.replace('type_reduction', '');
            var type_reduction = $("#type_reduction" + num).val();
            
            if(type_reduction != "") {
                $("#reduction" + num).attr('readonly', false);
            } else {
                $("#reduction" + num).attr('readonly', true);
            }
        });
        
        $(document).on('change', '.type_reduction_globale', function() {
            var type_reduction_globale = $("#type_reduction_globale").val();
            
            if(type_reduction_globale != "") {
                $("#reduction_globale").attr('readonly', false);
            } else {
                $("#reduction_globale").attr('readonly', true);
                $("#reduction_globale").val('');
            }
        });
        
        $('#appliquer_reduction').click(function() {
            var reduction_globale = $("#reduction_globale").val();
            var sans_tva = $("#no_tva").is(':checked');
            var prix_ht_total = parseFloat($(".total_ttc").html());
            
            if(reduction_globale != "") {
                if($("#type_reduction_globale").val() == "pourcentage") {
                    montant_reduction_globale = parseFloat(prix_ht_total * reduction_globale / 100).toFixed(2);
                } else if($("#type_reduction_globale").val() == "montant") {
                    montant_reduction_globale = parseFloat(reduction_globale).toFixed(2);
                }
                
                prix_ht_total = parseFloat(prix_ht_total - montant_reduction_globale);
                
                if(sans_tva) {
                    net_a_payer = parseFloat(prix_ht_total);
                } else {
                    net_a_payer = parseFloat(prix_ht_total * (1 + tva / 100));
                }
                
                montant_reduction_globale = parseFloat(montant_reduction_globale) + parseFloat(montant_reduction_total);
            } else {
                montant_reduction_globale = parseFloat(montant_reduction_total);
            }
            
            $('.total_reduction').html(`<span class="text-danger">-${montant_reduction_globale}</span>`);
            $('.net_a_payer').html(`<span>${net_a_payer.toFixed(2)} €</span>`);
        });

        // Initialiser le résumé au chargement de la page
        $('#actualiser').click();
    </script>
    @include('partials._sidebar_collapse')
@endsection
