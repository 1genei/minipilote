@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
@endsection

@section('title', 'Ajout devi')

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="">Devis</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Devis</h4>
                </div>
            </div>

            <div class="col-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-sm-2 ">
                                {{-- <a href="{{ URL::previous() }}" type="button" class="btn btn-outline-primary"><i
                                        class="uil-arrow-left"></i>
                                    Retour</a> --}}
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

                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card-box-->
            </div>
        </div>
        <!-- end page title -->

        <!-- end row-->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">



                        <!-- end row-->
                        <div class="row">

                            <div class="col-6">
                                @if (session('message'))
                                    <div class="alert alert-success text-secondary alert-dismissible ">
                                        <i class="dripicons-checkmark me-2"></i>
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <a href="#" class="alert-link"><strong> {{ session('message') }}</strong></a>
                                    </div>
                                @endif


                            </div>
                        </div>

                        <form action="{{ route('devis.store') }}" method="post" id="form_devis">
                            @csrf

                        
                        <div class="row">
                            <div class="col-lg-8">
                        
                                <div class="col-lg-12 col-md-12 col-sm-12" id="palier">
                                    <div class="panel panel-pink m-t-15">
                                        <div class="panel-heading"><strong>Devis </strong></div>
                                        <div class="panel-body">
                                        
                                            <hr>
                                            <br>
                                            <div class="row">
                        
                                                <div class="col-auto ">
                                                    <div class="mb-3 ">
                                                        <label for="numero_devis" class="form-label">
                                                            Numéro du devis <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="number" id="numero_devis" name="numero_devis" min="{{$prochain_numero_devis}}"
                                                            value="{{$prochain_numero_devis}}" class="form-control" style="font-size: 1.3rem;color: #772e7b; width: 200px;" required>
                    
                                                        @if ($errors->has('numero_devis'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary " role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('numero_devis') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                       
                                           
                                                <div class="col-auto ">
                                                    <div class="mb-3 ">
                                                        <label for="nom_devis" class="form-label">
                                                            Nom du devis 
                                                        </label>
                                                        <input type="text" id="nom_devis" name="nom_devis" style="font-size: 1.3rem;color: #772e7b;width: 200px;"
                                                            value="{{ old('nom_devis') ? old('nom_devis') : '' }}" class="form-control" >
                    
                                                        @if ($errors->has('nom_devis'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary " role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('nom_devis') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>      
                                                
                                                <div class="col-auto ">
                                                    <div class=" mb-3">
                                                        <label for="client_prospect_id" class="form-label">
                                                            Sélectionnez le Client/Prospect <span class="text-danger">*</span>
                                                        </label>
                                                        <select name="client_prospect_id" id="client_prospect_id" class=" form-control select2" required
                                                            data-toggle="select2" >
                                                            <option value=""></option>
                                                            @foreach ($contactclients as $contact)
                                                            
                                                                @if ($contact->type =="individu")
                                                                    <option value="{{ $contact->id }}">
                                                                        {{ $contact->individu?->nom }} {{ $contact->individu?->prenom }}
                                                                    </option>
                                                                @else
                                                                    <option value="{{ $contact->id }}">
                                                                        {{ $contact->entite?->raison_sociale }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('client_prospect_id'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary " role="alert">
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                                <strong>{{ $errors->first('client_prospect_id') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>   
                    
                                        </div>
                                        <hr>
                                      
                                    <div class="filtres">
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
                                                  
                                                    <button class="btn btn-warning add_field_button" style="margin-left: 53px;">
                                                        Ajouter au devis
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                        
                                        
                                        <hr>
                                            <div class="input_fields_wrap">
                                               
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <button type="button" id="actualiser" class="btn btn-info"><i class="mdi mdi-reload me-1"></i> <span>Actualiser</span> </button>

                                <div class="border p-3 mt-4 mt-lg-0 rounded">
                                    <h4 class="header-title mb-3">Résumé du devis</h4>

                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <tbody >
                                                
                                                <th>
                                                    <th>Produit :</th>
                                                    <th>Montant TTC</th>
                                                    <th>Montant TVA</th>
                                                </th>
                                                
                                            </tbody>
                                        </table>
                                        
                                        <table class="table mb-0">
                                            <tbody class="resume_devis">
                                                
                                                
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- end table-responsive -->
                                </div>

                               <div class="row">                               
                                    <div class="col-auto">
                                        <label for="type_reduction_globale">Réduction: </label>
                                    
                                        <select class="form-select type_reduction_globale" id="type_reduction_globale" name="type_reduction_globale">
                                            <option> </option>
                                           <option value="pourcentage">%</option>
                                           <option value="montant">EUR</option>
                                     
                                        </select>
                                    </div>
                                   
                                    <div class="col-auto">
                                        <label for="reduction_globale"> </label>
                                        <input class="form-control reduction_total" type="number" step="0.01" min="0" value="" id="reduction_globale" name="reduction_globale" readonly >
                                    </div>
                                    
                                    <div class="col-auto">
                                        <label for="reduction_globale"> </label>                                    
                                        <button class="input-group-text btn-light" id="appliquer_reduction" type="button">Appliquer</button>                                        
                                    </div>
                               </div>
                               
                               

                            </div> <!-- end col -->
                        </div>
                        

                        <div class="row mt-3">
                            <div class="modal-footer" style="justify-content:flex-start;">

                                <button type="submit" id="enregistrer" wire:click="submit"
                                    class="btn btn-primary">Enregistrer</button>

                            </div>
                        </div>

                        </form>
                        <style>
                            
                            
                            @media (max-width: 999px) {
                                .select2-container .select2-selection--single {
                                    height: calc(1.69em + 0.9rem + 2px);
                                    min-width: 110px;
                                    /* max-width: 150px; */
                                    
                                }
                            }
                            
                                   
                            @media (min-width: 1000px) {
                                .select2-container .select2-selection--single {
                                    height: calc(1.69em + 0.9rem + 2px);
                                    min-width: 150px;
                                    /* max-width: 200px; */
                                }
                                .select_produit{
                                    width: 300px;
                                    font-size:12px;
                                
                                }
                            }
                            .quantite{
                                width: 80px;
                            }
                            .prix_ht{
                                width: 100px;
                            }
                            .tva{
                                width: 120px;
                            }
                            .type_reduction{
                                width: 120px;
                            }
                            .reduction{
                                width: 100px;}
                                                        
                            .filtres{
                                background-color:#f1f1f1;
                                padding: 40px 40px 40px 40px;
                            }
                        </style>



                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->



    </div> <!-- End Content -->
@endsection

@section('script')

    {{-- Filtrer les produits --}}
    <script>
        var produits = @json($produits);
        var tab_produits = [];
        var liste_produits = "";
        
        
        $("#produit").empty(); // Clear the current options in the select
        produits.forEach(function(produit) {
            $("#produit").append('<option value="' + produit.id + '">' + produit.nom + '</option>');
            
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
        var tab_tvas = [];
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
        
       
       
        var y = 0;
        $(document).ready(function() {
            var max_produits = 30;
            var wrapper = $(".input_fields_wrap");
            var add_button = $(".add_field_button");

            
            
            $(add_button).click(function(e) {
                e.preventDefault();

                if (y < max_produits) {
                    var prix_ht = 0;

                    var i = 1;
                    var prix_ttc_total = 0;
                    var montant_tva_total = 0;
                    
               
                    // nom_produit = $("#produit" + y + '').val();
                    nom_produit = $("#produit").val();
                        


                    if(nom_produit != "" && nom_produit !== undefined ){
                        y++;
                    
                        var fieldHTML = `
                                <div class = "row gy-2 gx-2 align-items-center field${y}"> 
                                    <div class="col-auto">
                                        <label for="produit${y}">Produit: </label> 
                                        <select class="form-control select2 liste_produits select_produit" width="80px" required id="produit${y}" name="produit${y}">
                                            <option></option>
                                            ${liste_produits}
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <label for="quantite${y}">Quantité: </label>
                                        <input class="form-control quantite" type="number"  min="1" value="1" id="quantite${y}" required name="quantite${y}"/>
                                    </div>
                                    <div class="col-auto">
                                        <label for="prix_ht${y}">Prix HT (€): </label>
                                        <input class="form-control prix_ht" type="number" min="1" step="0.01" value="${prix_ht}" required id="prix_ht${y}" name="prix_ht${y}" >
                                    </div>
                                    <div class="col-auto">
                                        <label for="tva${y}">Tva: </label>
                                        <select class="form-select liste_tvas tva" width="80px" id="tva${y}" name="tva${y}">
                                            <option></option>
                                            ${liste_tvas}
                                        </select>
                                    </div> 
                                    <div class="col-auto">
                                        <label for="type_reduction${y}">Réduction: </label>
                                        <select class="form-select type_reduction" id="type_reduction${y}" name="type_reduction${y}">
                                            <option> </option>
                                            <option value="pourcentage">%</option>
                                            <option value="montant">EUR</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <label for="reduction${y}"> </label>
                                        <input class="form-control reduction" type="number" step="0.01" min="0" id="reduction${y}" name="reduction${y}" readonly >
                                    </div>
                                    <div class="col-auto"><a href="#" class="remove_field btn btn-danger btn-sm"><i class="mdi mdi-delete"></i></a></div></br>
                                </div>`
             
                        $(wrapper).append(fieldHTML);
                        
                        $("#produit" + y + ' option[value="'+nom_produit+'"]').attr("selected",true);                        
                        $("#quantite" + y + '').val(1);                        
                        $("#prix_ht" + y + '').val(tab_produits[nom_produit].prix_vente_ht);                        
                        $("#tva" + y + ' option[value="'+tab_produits[nom_produit].tva_id+'"]').attr("selected",true);                        
                        $("#type_reduction" + y + ' option[value="pourcentage"]').attr("selected",true);                        
                        $("#reduction" + y + '').val(0);                        
                        $("#pal" + y + '').hide();                        
                        $("#quantite" + y + '').change(function() {
                            var quantite = $(this).val();
                            var prix_ht = $("#prix_ht" + y + '').val();
                            var tva = $("#tva" + y + '').val();
                            var prix_ttc = quantite*prix_ht * (1 + tva / 100);
                            var montant_tva = prix_ttc - prix_ht;
                            
                            prix_ttc = prix_ttc.toFixed(2);
                            montant_tva = montant_tva.toFixed(2);
                            
                            $("#prix_ttc" + y + '').val(prix_ttc);
                            $("#montant_tva" + y + '').val(montant_tva);
                            
                        });
                        
                        $("#prix_ht" + y + '').change(function() {
                            var quantite = $("#quantite" + y + '').val();
                            var prix_ht = $(this).val();
                            var tva = $("#tva" + y + '').val();
                            var prix_ttc = quantite*prix_ht * (1 + tva / 100);
                            var montant_tva = prix_ttc - prix_ht;
                            
                            prix_ttc = prix_ttc.toFixed(2);
                            montant_tva = montant_tva.toFixed(2);
                            
                            $("#prix_ttc" + y + '').val(prix_ttc);
                            $("#montant_tva" + y + '').val(montant_tva);
                            
                        });
                        
                        $("#tva" + y + '').change(function() {
                            var quantite = $("#quantite" + y + '').val();
                            var prix_ht = $("#prix_ht" + y + '').val();
                            var tva = $(this).val();
                            var prix_ttc = quantite*prix_ht * (1 + tva / 100);
                            var montant_tva = prix_ttc - prix_ht;
                            
                            prix_ttc = prix_ttc.toFixed(2);
                            montant_tva = montant_tva.toFixed(2);
                            
                            $("#prix_ttc" + y + '').val(prix_ttc);
                            $("#montant_tva" + y + '').val(montant_tva);
                            
                        });
                        
                        
                        // Réinitialiser le plugin select2 pour le nouveau champ ajouté
              
                        $('#produit' + y).select2();
                        
                    }
                        
                 
                }else{
                
                    swal.fire(
                            'Ajout impossible!',
                            'Le maximum de produit est atteint, vous ne pouvez plus ajouter de nouveaux  produits!',
                            'error'
                        );
                }
            });

            $(wrapper).on("click", ".remove_field", function(e) {
                e.preventDefault();
                if (y > 2) $("#pal" + (y - 1) + '').show();
                $(this).parent().parent('div').remove();
                y--;
            })
        });
        
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
            montant_tva_total = 0;
            montant_reduction_total = 0;
            while (i <= y) {
                let tmp = parseFloat($("#quantite" + i + '').change().val());
              
                var libelle_reduction = "";
                
                nom_produit = $("#produit" + i + '').val();
                prix_ht = $("#prix_ht" + i + '').val();
                tva_id = $("#tva" + i + '').val();
                tva = tab_tvas[tva_id];
                quantite = $("#quantite" + i + '').val();
                prix_ttc = quantite*prix_ht * (1 + tva / 100);
                montant_tva = prix_ttc - prix_ht;
                
                prix_ttc = prix_ttc.toFixed(2);
                montant_tva = montant_tva.toFixed(2);
                
                prix_ttc_total += parseFloat(prix_ttc); 
                montant_tva_total += parseFloat(montant_tva); 
                
                // réduction
                
                var type_reduction = $("#type_reduction"+i).val();
                var reduction = $("#reduction"+i).val();
                
                var montant_reduction = 0;
                
                if(type_reduction == "pourcentage"){
                    
                    montant_reduction = prix_ttc  * reduction / 100;
                }else if(type_reduction == "montant"){
                    montant_reduction = parseFloat(reduction) ;
                    
                }
                montant_reduction_total += montant_reduction;
                
                
                // prix_ttc_total = parseFloat(prix_ttc_total - montant_reduction);
                
                if(montant_reduction > 0 ){
                    libelle_reduction = " <span class='text-danger'>(-"+montant_reduction.toFixed(2)+")</span>"; 
                }
                
                prix_ttc = parseFloat(prix_ttc).toFixed(2);
                montant_tva = parseFloat(montant_tva).toFixed(2);
                
                if (nom_produit != "" && tab_produits_init[nom_produit] !== undefined && prix_ht != "" && tva != "" && quantite != "") {
                    resume_devis[i] = `<tr><td> ${tab_produits_init[nom_produit].nom}  x ${quantite} </td><td> ${prix_ttc} ${libelle_reduction } </td> <td> ${montant_tva} </td> </tr>`;
                }
                i++;
            }
        
            if(!isNaN(prix_ttc_total)){
            
                net_a_payer = parseFloat(prix_ttc_total - montant_reduction_total);
            
                resume_devis.push(`
                <tr style="background-color: #f1f3fa;font-size: 13px; font-weight: bold;"><th>Total TTC :</td><td class="total_ttc"> ${prix_ttc_total.toFixed(2)} </th><th></th> </tr>
                <tr style="background-color: #f1f3fa;font-size: 13px; font-weight: bold;"><th>Total TVA :</td><td class=""> ${montant_tva_total.toFixed(2)} </th><th></th> </tr>
                <tr style="background-color: #f1f3fa;font-size: 13px; font-weight: bold;"><th>Réduction :</td><td class="text-danger total_reduction"> - ${montant_reduction_total.toFixed(2)} </th><th></th> </tr>
                <tr style="background-color: #f1f3fa;font-size: 15px; font-weight: bold;border:2px solid #ff5b5b"><th>NET À PAYER :</td><td class="net_a_payer"> ${net_a_payer.toFixed(2)} €</th> <th></th> </tr>`);
                
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
            
            if(reduction_globale != ""){
            
                if(type_reduction_globale == "pourcentage"){
                        
                    montant_reduction_globale = parseFloat(prix_ttc_total  * reduction_globale / 100).toFixed(2);
                    
                }else if(type_reduction_globale == "montant"){
                    montant_reduction_globale = parseFloat(reduction_globale).toFixed(2) ; 
                }
                
                montant_reduction_globale= parseFloat(montant_reduction_globale) + parseFloat(montant_reduction_total);
                net_a_payer = parseFloat(prix_ttc_total - montant_reduction_globale);
                
                
            }else{
                montant_reduction_globale=  parseFloat(montant_reduction_total);
                net_a_payer = parseFloat(prix_ttc_total - montant_reduction_total);
                
            }
            
            
            $('.total_reduction').html(' <span class="text-danger">-'+montant_reduction_globale.toFixed(2)+'</span>');
            $('.net_a_payer').html(' <span class="">'+net_a_payer.toFixed(2)+' €</span>');    
            
        });
    
    </script>


@endsection
