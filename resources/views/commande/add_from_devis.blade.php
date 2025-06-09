@extends('layouts.app')

@php
use Illuminate\Support\Facades\Crypt;
@endphp

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
                    <h4 class="page-title" style="font-size: 1.2rem;">Créer une commande à partir du <a href="{{ route('devis.show', Crypt::encrypt($devis->id)) }}" target="_blank" style="color: #000;">devis {{ $devis->numero_devis }}</a></h4>
                </div>
            </div>
            <div class="col-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-sm-2 ">
                                <a href="{{ URL::previous() }}" type="button" class="btn btn-outline-primary">
                                    <i class="uil-arrow-left"></i>
                                    Retour
                                </a>
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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        {{-- Afficher les erreurs --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        
                        <form action="{{ route('commande.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="hidden" name="devi_id" value="{{ $devis->id }}">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Numéro de commande <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="numero_commande" value="{{ $numero_commande }}" required>
                                            @if ($errors->has('numero_commande'))
                                                <span class="text-danger">{{ $errors->first('numero_commande') }}</span>
                                            @endif
                                        </div>
        
                                        <div class="col-md-6">
                                            <label class="form-label">Date de commande <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="date_commande" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Client/Prospect <span class="text-danger">*</span>
                                                <span class="badge bg-danger">
                                                    {{ $devis->client_prospect()->type == 'individu' ? $devis->client_prospect()->individu->nom . ' ' . $devis->client_prospect()->individu->prenom : $devis->client_prospect()->entite->raison_sociale }}
                                                </span>
                                            </label>
                                            <select class="form-control select2" data-toggle="select2" name="client_prospect_id" id="client_prospect_id" required>
                                                <option value="{{ $devis->client_prospect_id }}">{{ $devis->client_prospect()->type == 'individu' ? $devis->client_prospect()->individu->nom . ' ' . $devis->client_prospect()->individu->prenom : $devis->client_prospect()->entite->raison_sociale }}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            {{-- Modal pour ajouter un contact --}}
                                            <label for="add-contact" class="form-label">.</label> <br>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-contact">
                                                <i class="mdi mdi-plus-circle me-1"></i> Ajouter un nouveau contact
                                            </button>
                                        </div>
                                    </div>
        
                                    
        
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Date de réalisation prévue</label>
                                            <input type="date" class="form-control" value="" name="date_realisation_prevue">
                                        </div>
        
                                        <div class="col-md-6">
                                            <label class="form-label">Mode de paiement <span class="text-danger">*</span></label>
                                            <select class="form-select" name="mode_paiement" required>
                                                <option value="Carte bancaire">Carte bancaire</option>
                                                <option value="Espèce">Espèce</option>
                                                <option value="Chèque">Chèque</option>
                                                <option value="Virement">Virement</option>
                                                <option value="Autre">Autre</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">                                      
                                        <div class="col-md-6">
                                            <label class="form-label">Provenance</label>
                                            <select class="form-select" name="provenance">
                                                <option value="">...</option>
                                                <option value="Site web">Site web</option>
                                                <option value="Wonderbox">Wonderbox</option>
                                                <option value="Smartbox">Smartbox</option>
                                                <option value="Sport découverte">Sport découverte</option>
                                                <option value="Prospection">Prospection</option>
                                                <option value="Autre">Autre</option>
                                            </select>
                                        </div>

                                       
                                    </div>
                                    <div class="row mb-3"> 
                                        <div class="col-md-6">
                                            <label class="form-label">Numéro de commande provenance</label>
                                            <input type="text" class="form-control" value="" name="numero_commande_provenance">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Date de commande provenance</label>
                                            <input type="date" class="form-control" value="" name="date_commande_provenance">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label class="form-label">Statut de la commande</label>
                                                    <select class="form-select" name="statut">
                                                        <option value="A planifier">A planifier</option>
                                                        <option value="A planifier">A planifier</option>
                                                        <option value="Planifiée">Planifiée</option>
                                                        <option value="Exécutée">Exécutée</option>
                                                        <option value="Annulée">Annulée</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label class="form-label">Statut de paiement</label>
                                                    <select class="form-select" name="statut_paiement">
                                                        <option value="A payer">A payer</option>
                                                        <option value="Payée">Payée</option>
                                                        <option value="Partiellement payée">Partiellement payée</option>
                                                        <option value="Annulée">Annulée</option>
                                                        <option value="Sans suite">Sans suite</option>                                                        
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3" style="margin-top: 20px; background-color: #bacbdb; padding: 10px;">
                                                <div class="col-md-12">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="no_tva" name="no_tva" >
                                                        <label class="form-check-label" for="no_tva">Ne pas facturer la TVA</label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    
                                </div>
                                
                            </div>

                            <hr>
                            <div class="card border">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                    
                                            <div class="col-lg-12 col-md-12 col-sm-12" id="palier">
                                                <div class="panel panel-pink m-t-15">
                                                    <div class="panel-heading"><strong>Produits </strong></div>
                                                    <div class="panel-body">
                                                        <div class="filtres mt-5">
                                                            <div class="row">
                                                                
                                                                <div class="col-auto ">
                                                                    <div class="mb-3 ">
                                                                        <label for="categorie" class="form-label">
                                                                            Catégorie
                                                                        </label>
                                                                        <select name="categorie" id="categorie" class="filtrer form-control select2"
                                                                            data-toggle="select2" >
                                                                            <option value="">Sélectionnez la catégorie</option>
                                                                            @foreach ($categories as $categorie)
                                                                                <option value="{{ $categorie->id }}">
                                                                                    {{ $categorie->nom }}
                                                                                </option>
                                                                            @endforeach 
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-auto ">
                                                                    <div class="mb-3 ">
                                                                        <label for="voiture" class="form-label">
                                                                            Voiture
                                                                        </label>
                                                                        <select name="voiture" id="voiture" class=" filtrer form-control select2"
                                                                            data-toggle="select2" >
                                                                            <option value="">Sélectionnez la voiture  </option>
                                                                            @foreach ($voitures as $voiture)
                                                                                <option value="{{ $voiture->id }}">
                                                                                    {{ $voiture->nom }}
                                                                                </option>
                                                                            @endforeach 
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-auto ">
                                                                    <div class="mb-3 ">
                                                                        <label for="circuit" class="form-label">
                                                                            Circuit
                                                                        </label>
                                                                        <select name="circuit" id="circuit" class=" filtrer form-control select2"
                                                                            data-toggle="select2" >
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
                                                                <div class="col-auto ">
                                                                    <div class="mb-3 ">
                                                                        <label for="produit" class="form-label">
                                                                            Produit
                                                                        </label>
                                                                        <span id="nb_produit" ></span>
                                                                        <select name="produit" id="produit" class=" form-control select2"
                                                                            data-toggle="select2" >
                                                                            <option value=""></option>
                                                                            {{-- @foreach ($produits as $produit)
                                                                                <option value="{{ $produit->id }}">{{ $produit->nom }}</option>
                                                                            @endforeach --}}
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto ">
                                                                    <div class="mb-3 mt-3 ">
                                                                    
                                                                        <button class="btn btn-info add_field_button" style="margin-left: 53px;">
                                                                            <i class="mdi mdi-plus-circle"></i> Ajouter un produit
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>                                                            
                                                            
                                                        <hr>
                                                        <div class="input_fields_wrap" style="margin-top: 20px; margin-bottom: 20px; background-color: #f8f9fa;">
                                                            @php
                                                                $y = 0;
                                                            @endphp
                                                            @foreach($devis->produits as $produit)
                                                                @php 
                                                                    $y = $loop->iteration; 
                                                                    $contact_beneficiaire = $produit->pivot->beneficiaire_id ? App\Models\Contact::find($produit->pivot->beneficiaire_id) : '';       
                                                                    if($contact_beneficiaire){
                                                                        $nom_beneficiaire = $contact_beneficiaire->type == 'individu' ? $contact_beneficiaire->individu->nom . ' ' . $contact_beneficiaire->individu->prenom : $contact_beneficiaire->entite->raison_sociale;
                                                                    }else{
                                                                        $nom_beneficiaire = '';
                                                                    }                                                        
                                                                @endphp

                                                                <div class="row gy-2 gx-2 align-items-center field{{$y}}"> 
                                                                    <div class="col-4">
                                                                        <label for="produit{{$y}}">Produit: </label> 
                                                                        <select class="form-control select2 liste_produits select_produit actualiser" id="produit{{$y}}" value="{{ $produit->id }}" name="produit{{$y}}">
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
                                                                    <div class="col-2">
                                                                        <label for="beneficiaire{{$y}}">Bénéficiaire : <span class="badge bg-danger"> {{ $nom_beneficiaire }} </span> </label>
                                                                        <select class="form-control select2 beneficiaire_id" id="beneficiaire{{$y}}" value="{{$produit->pivot->beneficiaire_id }}" name="beneficiaire{{$y}}">
                                                                        
                                                                        </select>
                                                                        @if($produit->pivot->beneficiaire_id)
                                                                            <input type="hidden" name="exist_beneficiaire_id{{$y}}" value="{{$produit->pivot->beneficiaire_id}}">
                                                                        @endif
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
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-5">
                                            <button type="button" id="actualiser" class="btn btn-info"><i class="mdi mdi-reload me-1"></i> <span>Actualiser</span> </button>
            
                                            <div class="border p-3 mt-4 mt-lg-0 rounded">
                                                <h4 class="header-title mb-3">Résumé de la commande</h4>
            
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
                                               


                                                <!-- end table-responsive -->
                                            </div>
            
                                            <div class="row">                               
                                                    <div class="col-auto">
                                                        <label for="type_reduction_globale">Réduction globale sur HT: </label>
                                                    
                                                        <select class="form-select type_reduction_globale" id="type_reduction_globale" name="type_reduction_globale">
                                                            <option value=""></option>
                                                            <option value="pourcentage" {{ $devis->type_remise == 'pourcentage' ? 'selected' : '' }}>%</option>
                                                            <option value="montant" {{ $devis->type_remise == 'montant' ? 'selected' : '' }}>EUR</option>
                                                        </select>
                                                    </div>
                                                
                                                    <div class="col-auto">
                                                        <label for="reduction_globale"> </label>
                                                        <input class="form-control reduction_total" type="number" step="0.01" min="0" value="{{ $devis->remise }}" id="reduction_globale" name="reduction_globale"  @if($devis->remise == 0) readonly @endif >
                                                    </div>
                                                    
                                                    <div class="col-auto">
                                                        <label for="reduction_globale"> </label>                                    
                                                        <button class="input-group-text btn-light" id="appliquer_reduction" type="button">Appliquer</button>                                        
                                                    </div>
                                            </div>
                                        
                                        
            
                                        </div> <!-- end col -->
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-12 text-end">
                                    <a href="{{ route('commande.index') }}" class="btn btn-light btn-lg me-2">Annuler</a>
                                    <button type="submit" class="btn btn-primary btn-lg">Créer la commande</button>
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
        initContactsSelect2('.beneficiaire_id');
        $(document).ready(function(){
            $("#actualiser").click();
        });
    </script>
    
    {{-- Filtrer les produits --}}
    <script>
        var produits = @json($produits);
        var tab_produits = [];
        var liste_produits = "";
        
        
        $("#produit").empty(); // Clear the current options in the select
        produits.forEach(function(produit) {
            $("#produit").append('<option value="' + produit.id + '">' + produit.nom + '</option>');
            
        });
        
        // Si on change la présence de tva
        $("#no_tva").change(function(){
            $("#actualiser").click();
        });
        
        $(".filtrer").change(function(e){
            
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
                    // Handle error
                    console.error("An error occurred: " + status + " " + error);
                }
            });
        
        });

//   #####  Ajouts de produits 

    
        
        var tvas = @json($tvas);
        var tab_tvas = {};
        var resume_devis = [];
        
        var nb_produit = produits.length;
        $('#nb_produit').html('<span class="text-danger">'+nb_produit+' produits trouvés</span>');
        

        var liste_tvas = "";
        
        tvas.forEach(element => {
            liste_tvas += '<option value="' + element.id + '">' + element.nom + '</option>'; 
            tab_tvas[element.id] = element.taux;
        });
        
        produits.forEach(element => {
            liste_produits += '<option value="' + element.id + '">' + element.nom + '</option>';        
            tab_produits[element.id] = element;
        });
        
        var tab_produits_init = tab_produits;
        
        
        //    Lorsqu'on change le produit
        
        $(document).on('change', '.select_produit', function() { 
            var id = $(this).val();

            var prix_ht = tab_produits[id].prix_vente_ht;
            var tva = tab_produits[id].tva_id;
            var prix_ttc = prix_ht * (1 + tva / 100);
            
            
            $(this).parent().parent().find('.prix_ht').val(prix_ht);
            $(this).parent().parent().find('.tva option[value="'+tva+'"]').attr("selected",true);
            
        });
        
        
        
        var y = {{$y}};
               
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
                                    <select class="form-control select2 liste_produits select_produit actualiser" id="produit${y}" name="produit${y}">
                                        <option></option>
                                        ${liste_produits}
                                    </select>
                                </div>
                                <div class="col-1">
                                    <label for="quantite${y}">Quantité: </label>
                                    <input class="form-control quantite " type="number"  min="1" value="1" id="quantite${y}" required name="quantite${y}"/>
                                </div>
                                <div class="col-1">
                                    <label for="prix_ht${y}">Prix HT (€): </label>
                                    <input class="form-control prix_ht actualiser" type="number" min="1" step="0.01" value="${tab_produits[nom_produit].prix_vente_ht}" required id="prix_ht${y}" name="prix_ht${y}" >
                                </div>
                                <div class="col-1">
                                    <label for="tva${y}">Tva: </label>
                                    <select class="form-select liste_tvas tva actualiser" width="80px" id="tva${y}" name="tva${y}">
                                        <option></option>
                                        ${liste_tvas}
                                    </select>
                                </div> 
                                <div class="col-1">
                                    <label for="type_reduction${y}">Réduction: </label>
                                    <select class="form-select type_reduction actualiser" id="type_reduction${y}" name="type_reduction${y}">
                                        <option> </option>
                                        <option value="pourcentage">%</option>
                                        <option value="montant">EUR</option>
                                    </select>
                                </div>
                                <div class="col-1">
                                    <label for="reduction${y}"> </label>
                                    <input class="form-control reduction actualiser" type="number" step="0.01" min="0" id="reduction${y}" name="reduction${y}" readonly >
                                </div>
                                <div class="col-2">
                                    <label for="beneficiaire${y}">Bénéficiaire : </label>
                                    <select class="form-control select2" id="beneficiaire${y}" name="beneficiaire${y}">
                                        <option value="">Sélectionnez un bénéficiaire</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <a href="#" class="remove_field btn btn-danger btn-sm">
                                        <i class="mdi mdi-delete"></i>
                                    </a>
                                </div>
                            </div>`;
                
                        $(wrapper).append(fieldHTML);
                        
                        // Initialiser select2 sur le nouveau champ bénéficiaire
                        initContactsSelect2('#beneficiaire' + y);
                        
                        // Initialiser select2 sur le nouveau champ produit
                        $(`#produit${y}`).select2({
                            placeholder: "Sélectionnez un produit",
                            allowClear: true,
                            width: '100%'
                        });
                        
                        // Sélectionner le produit
                        $(`#produit${y}`).val(nom_produit).trigger('change');
                        
                        $("#quantite" + y + '').val(1);                        
                        $("#prix_ht" + y + '').val(tab_produits[nom_produit].prix_vente_ht);                        
                        $("#tva" + y + ' option[value="'+tab_produits[nom_produit].tva_id+'"]').attr("selected",true);                       
                        $("#pal" + y + '').hide();                        
                        $("#quantite" + y + '').change(function() {
                            var quantite = $(this).val();
                            var prix_ht = $("#prix_ht" + y + '').val();
                            var tva = $("#tva" + y + '').val();
                            var sans_tva = $("#no_tva").is(':checked');

                            if(sans_tva){
                                prix_ttc = quantite*prix_ht;
                            }else{
                                prix_ttc = quantite*prix_ht * (1 + tva / 100);
                            }
                            
                            var montant_tva = prix_ttc - prix_ht;
                            
                            prix_ttc = prix_ttc.toFixed(2);
                            montant_tva = montant_tva.toFixed(2);
                            
                            $("#prix_ttc" + y + '').val(prix_ttc);
                            $("#montant_tva" + y + '').val(montant_tva);

                            // $('#actualiser').click();
                            
                        });
                        
                        $("#prix_ht" + y + '').change(function() {
                            var quantite = $("#quantite" + y + '').val();
                            var prix_ht = $(this).val();
                            var tva = $("#tva" + y + '').val();
                            var sans_tva = $("#no_tva").is(':checked');

                            if(sans_tva){
                                prix_ttc = quantite*prix_ht;
                            }else{
                                prix_ttc = quantite*prix_ht * (1 + tva / 100);
                            }
                            //var prix_ttc = quantite*prix_ht * (1 + tva / 100);
                            var montant_tva = prix_ttc - prix_ht;
                            
                            prix_ttc = prix_ttc.toFixed(2);
                            montant_tva = montant_tva.toFixed(2);
                            
                            $("#prix_ttc" + y + '').val(prix_ttc);
                            $("#montant_tva" + y + '').val(montant_tva);

                            // $('#actualiser').click();
                            
                        });
                        
                        $("#tva" + y + '').change(function() {
                            var quantite = $("#quantite" + y + '').val();
                            var prix_ht = $("#prix_ht" + y + '').val();
                            var tva = $(this).val();
                            var sans_tva = $("#no_tva").is(':checked');

                            if(sans_tva){
                                prix_ttc = quantite*prix_ht;
                            }else{
                                prix_ttc = quantite*prix_ht * (1 + tva / 100);
                            }

                            var montant_tva = prix_ttc - prix_ht;

                            prix_ttc = prix_ttc.toFixed(2);
                            montant_tva = montant_tva.toFixed(2);
                            
                            $("#prix_ttc" + y + '').val(prix_ttc);
                            $("#montant_tva" + y + '').val(montant_tva);

                            // $('#actualiser').click();
                            
                        });

                        
                        
                        $('#actualiser').click();
                    }
                } else {
                    swal.fire(
                        'Ajout impossible!',
                        'Le maximum de produit est atteint!',
                        'error'
                    );
                }
            });

            $(wrapper).on("click", ".remove_field", function(e) {
                e.preventDefault();
                $(this).parent().parent('div').remove();
                // y--;
                $('#actualiser').click();
            });
        });
        
        // Actuaisation lorsqu'on modifie un produit
        $('.input_fields_wrap').on(' change keyup  focusout', '.actualiser', function(event) { 
            $('#actualiser').click();
        });


        // $('.input_fields_wrap').on('change keyup focusout', '.quantite, .prix_ht, .tva, .type_reduction, .reduction', function() {
        //     // Éviter la propagation en boucle
        //     if (!$(this).data('triggeredByActualiser')) {
        //         $(this).data('triggeredByActualiser', true);
        //         $('#actualiser').click();
        //         $(this).data('triggeredByActualiser', false);
        //     }
        // });
        // Actualiser la simulation du devis
        
        ligne_devis = 1 ;
        var prix_ttc_total = 0;
        var net_a_payer = 0;
        var montant_reduction_total = 0;
        var montant_tva_total = 0;
        
        $('#actualiser').click(function(e){
    
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

                if($("#produit" + i + '').val() != undefined){
             
                    let tmp = parseFloat($("#quantite" + i + '').change().val());
                
                    var libelle_reduction = "";
                    
                    quantite = $("#quantite" + i + '').val();
                    prix_ht = quantite * $("#prix_ht" + i + '').val();
                    nom_produit = $("#produit" + i + '').val();
                    tva_id = $("#tva" + i + '').val();
                    tva = tab_tvas[tva_id];
                    
                    // ##réduction
                    var type_reduction = $("#type_reduction"+i).val();
                    var reduction = $("#reduction"+i).val();
                    
                    
                    if(type_reduction == "pourcentage"){
                        
                        montant_reduction =  prix_ht  * reduction / 100;
                    }else if(type_reduction == "montant"){
                        montant_reduction = parseFloat(reduction) ;
                        
                    }
                    montant_reduction_total += montant_reduction;

                    prix_ht_reduction = prix_ht - montant_reduction;

                    if(sans_tva){
                        prix_ttc = prix_ht_reduction;
                    }else{
                        prix_ttc = prix_ht_reduction * (1 + tva / 100);
                    }
                    montant_tva = prix_ttc - prix_ht_reduction;
                    
                    prix_ttc = prix_ttc.toFixed(2);
                    montant_tva = montant_tva.toFixed(2);
                    
                    prix_ttc_total += parseFloat(prix_ttc); 
                    prix_ht_total += parseFloat(prix_ht_reduction); 
                    montant_tva_total += parseFloat(montant_tva); 
                    
                    
        
                    
                    if(montant_reduction > 0 ){
                        libelle_reduction = " <span class='text-danger'>(-"+montant_reduction.toFixed(2)+")</span>"; 
                    }
                    
                    prix_ttc = parseFloat(prix_ttc).toFixed(2);
                    montant_tva = parseFloat(montant_tva).toFixed(2);
                    
                    if (nom_produit != "" && tab_produits_init[nom_produit] !== undefined && prix_ht != "" && tva != "" && quantite != "") {
                        resume_devis[i] = `<tr style="width:100%" >
                            <td style="width:40%" > ${tab_produits_init[nom_produit].nom} </td>
                            <td style="width:10%"> ${quantite} </td>
                             <td style="width:15%"> ${prix_ht} </td>
                             <td style="width:10%; "> <span class="text-danger"> ${montant_reduction} </span> </td>
                             <td style="width:15%"> ${prix_ttc} </td>
                             <td style="width:10%"> ${montant_tva} </td>
                             </tr>`;

                    }
                    montant_reduction = 0;
                }
                i++;
            }
        
            if(!isNaN(prix_ttc_total)){
            
                // net_a_payer = parseFloat(prix_ttc_total - montant_reduction_total);
                net_a_payer = prix_ttc_total ;
                
                resume_devis.push(`
                <tr style="background-color: #f1f3fa;font-size: 13px; font-weight: bold; width:100%; ">
                    <td style="width:40%">Total :</td>
                    <td class="" style="width:10%"> </td>
                    <td class="total_ttc" style="width:15%"> ${prix_ht_total.toFixed(2)} </td>
                    <td class="total_ttc" style="width:10%"> <span class="text-danger"> ${montant_reduction_total.toFixed(2)} </span> </td>

                    <td class="total_ht" style="width:15%"> ${prix_ttc_total.toFixed(2)}</td>
                    <td class="" style="width:10%">${montant_tva_total.toFixed(2)} </td>
                </tr>                                             

                <tr style="background-color: #f1f3fa;font-size: 13px; font-weight: bold; width:100%; ">
                    <td style="width:40%">Réduction totale sur HT :</td>
                    <td class="text-danger total_reduction"  colspan="5">. </td>
                 
                </tr>
                <tr style="background-color: #f1f3fa;font-size: 15px; font-weight: bold; width:100%; border:2px solid #ff5b5b">
                    <td style="width:40%">NET À PAYER :</td>
                    <td class="net_a_payer" style="width:20%" colspan="5"> ${net_a_payer.toFixed(2)}  €</td>
                </tr>
                    
                `);
                
                $('.resume_devis').html(resume_devis.join(" "));
            
            }       
            
            // En cas de réduction globale
            $('#appliquer_reduction').click();
            
            ligne_devis++;            
            
        });
        
        
        // Choix du type de réduction pour les produits
        
        $(document).on('change', '.type_reduction', function() { 
            var id = $(this).attr('id');
            
            var num = id.replace('type_reduction', '');          
            var type_reduction = $("#type_reduction" + num + '').val();
            
    
            if(type_reduction != ""){
                $("#reduction" + num + '').attr('readonly', false);
            
            }else{
                $("#reduction" + num + '').attr('readonly', true);
            }           
        
        });
        
        
        // Choix du type de réduction pour la totalité
        var type_reduction_globale = "";
        var montant_reduction_globale = 0;
        var reduction_total = 0;
        type_reduction_globale = $("#type_reduction_globale").val();

        $(document).on('change', '.type_reduction_globale', function() { 
            
            
                
            type_reduction_globale = $("#type_reduction_globale").val();
            
    
            if(type_reduction_globale != ""){
                $("#reduction_globale").attr('readonly', false);
            
            }else{
                $("#reduction_globale").attr('readonly', true);
                $("#reduction_globale").val('');
            }           
        
        });
        
        // Appliquer une réduction globale
        $('#appliquer_reduction').click(function(){
            
            reduction_globale = $("#reduction_globale").val();
            var sans_tva = $("#no_tva").is(':checked');
            prix_ht_total = parseFloat($(".total_ttc").html());
            
            
            if(reduction_globale != ""){
                if(type_reduction_globale == "pourcentage"){
                        
                    montant_reduction_globale = parseFloat(prix_ht_total  * reduction_globale / 100).toFixed(2);
                    
                }else if(type_reduction_globale == "montant"){
                    montant_reduction_globale = parseFloat(reduction_globale).toFixed(2) ; 
                }
                
                // Réduction globale sur le prix HT
                prix_ht_total = parseFloat(prix_ht_total - montant_reduction_globale);

                if(sans_tva){
                    net_a_payer = parseFloat(prix_ht_total);
                }else{
                    net_a_payer = parseFloat(prix_ht_total * (1 + tva / 100));
                }

                

                montant_reduction_globale= parseFloat(montant_reduction_globale) + parseFloat(montant_reduction_total);
                
                
            }else{
                montant_reduction_globale=  parseFloat(montant_reduction_total);
                // net_a_payer = parseFloat(prix_ttc_total - montant_reduction_total);
                
            }
            
            
            $('.total_reduction').html(' <span class="text-danger">-'+montant_reduction_globale+'</span>');
            $('.net_a_payer').html(' <span class="">'+net_a_payer.toFixed(2)+' €</span>');    
            
        });
        
    </script>

    @include('partials._sidebar_collapse')
@endsection 