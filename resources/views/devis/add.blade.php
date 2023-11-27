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

                        <form action="{{ route('devis.store') }}" method="post">
                            @csrf
                        
                        
                        <div class="row">
                            <div class="col-lg-8">
                        
                                <div class="col-lg-12 col-md-12 col-sm-12" id="palier">
                                    <div class="panel panel-pink m-t-15">
                                        <div class="panel-heading"><strong>Devis </strong></div>
                                        <div class="panel-body">
                                            <div class="input_fields_wrap">
                                                <button class="btn btn-warning add_field_button" style="margin-left: 53px;">
                                                    Ajouter un produit
                                                </button>
                                                <div class="row gy-2 gx-2 align-items-center field1">
                        
                        
                                                    <div class="col-auto">
                                                        <label for="produit1">Produit: </label>
                                                        <select class="form-control select2 select_produit" id="produit1" name="produit1" data-toggle="select2" required>
                                                            <option value=""></option>
                                                            @foreach ($produits as $produit)
                                                                <option value="{{ $produit->id }}">{{ $produit->nom }}</option>
                                                            @endforeach
                                                     
                                                        </select>
                                                     
                                                            
                                                    </div>
                                                    <div class="col-auto">
                                                        <label for="quantite1">Quantité: </label>
                                                        <input class="form-control quantite" type="number" min="1"  id="quantite1" name="quantite1" value="1" >
                                                    </div>
                                                    <div class="col-auto">
                                                        <label for="prix_ht1">prix HT (€): </label>
                                                        <input class="form-control prix_ht" type="number"  value="0" id="prix_ht1" name="prix_ht1">
                                                    </div>
                                                    <div class="col-auto">
                                                        <label for="produit1">Tva: </label>
                                                    
                                                        <select class="form-select tva" id="tva1" name="tva1">
                                                            <option> </option>
                                                            @foreach ($tvas as $tva)
                                                                <option value="{{ $tva->id }}">{{ $tva->nom }}</option>
                                                            @endforeach
                                                     
                                                        </select>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
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

                               
                                <div class="alert alert-warning mt-3" role="alert">
                                    <strong>HYPBM</strong>
                                </div>

                                <div class="input-group mt-3">
                                    <input type="text" class="form-control form-control-light" placeholder="Code de réduction">
                                    <button class="input-group-text btn-light" type="button">Appliquer</button>
                                </div>

                            </div> <!-- end col -->
                        </div>
                        

                        <div class="row mt-3">
                            <div class="modal-footer">

                                <button type="submit" id="enregistrer" wire:click="submit"
                                    class="btn btn-primary">Enregistrer</button>

                            </div>
                        </div>

                        </form>
                        <style>
                            
                            
                            @media (max-width: 999px) {
                                .select2-container .select2-selection--single {
                                    height: calc(1.69em + 0.9rem + 2px);
                                    min-width: 150px;
                                    max-width: 200px;
                                }
                            }
                            
                                   
                            @media (min-width: 1000px) {
                                .select2-container .select2-selection--single {
                                    height: calc(1.69em + 0.9rem + 2px);
                                    min-width: 250px;
                                    max-width: 300px;
                                }
                            }
                            .quantite{
                                width: 80px;
                            }
                            .prix_ht{
                                width: 100px;
                            }
                            .tva{
                                width: 150px;
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

    {{-- #####  Ajouts de produits  --}}

    <script>
    
        var produits = @json($produits);
        var tvas = @json($tvas);
        var tab_produits = [];
        var tab_tvas = [];
        var resume_devis = [];
        
       

        var liste_produits = "";
        var liste_tvas = "";
        
        tvas.forEach(element => {
            liste_tvas += '<option value="' + element.id + '">' + element.nom + '</option>'; 
            tab_tvas[element.id] = element.taux;
        });
        
        produits.forEach(element => {
            liste_produits += '<option value="' + element.id + '">' + element.nom + '</option>';        
            tab_produits[element.id] = element;
        });
        
     
    //    Lorsqu'on change le produit
    
    $(document).on('change', '.select_produit', function() { 
        var id = $(this).val();

        var prix_ht = tab_produits[id].prix_vente_ht;
        var tva = tab_produits[id].tva_id;
        var prix_ttc = prix_ht * (1 + tva / 100);
        
        
        $(this).parent().parent().find('.prix_ht').val(prix_ht);
        $(this).parent().parent().find('.tva option[value="'+tva+'"]').attr("selected",true);
      
    });
        
       
       
        var y = 1;
        $(document).ready(function() {
            var max_produits = 30;
            var wrapper = $(".input_fields_wrap");
            var add_button = $(".add_field_button");

            
            
            $(add_button).click(function(e) {
                e.preventDefault();

                if (y < max_produits) {
                    var prix_ht = parseInt($("#ca_max" + y + '').change().val()) + 1;

                    var quantite_diff = (95 - (70));
                    var i = 1;
                    var prix_ttc_total = 0;
                    var montant_tva_total = 0;
                    
                    while (i <= y) {
                        let tmp = parseFloat($("#quantite" + i + '').change().val());
                        quantite_diff = (quantite_diff - tmp);
                        
                        nom_produit = $("#produit" + i + '').change().val();
                        prix_ht = $("#prix_ht" + i + '').change().val();
                        tva_id = $("#tva" + i + '').change().val();
                        tva = tab_tvas[tva_id];
                        quantite = $("#quantite" + i + '').change().val();
                        prix_ttc = quantite*prix_ht * (1 + tva / 100);
                        montant_tva = prix_ttc - prix_ht;
                        
                        prix_ttc = prix_ttc.toFixed(2);
                        montant_tva = montant_tva.toFixed(2);
                        
                        prix_ttc_total += parseFloat(prix_ttc); 
                        montant_tva_total += parseFloat(montant_tva); 
                        
                        if (nom_produit != "" && prix_ht != "" && tva != "" && quantite != "") {
                            resume_devis[i] = '<tr><td>' + tab_produits[nom_produit].nom + ' x ' + quantite + '</td><td>' + prix_ttc + ' €</td> <td>'+montant_tva+' €</td> </tr>';
                        }
                        i++;
                    }
                    
                    resume_devis.push('<tr style="background-color: #f1f3fa;font-size: 14px; font-weight: bold;"><th>Total :</td><td>' + prix_ttc_total + ' €</th> <th>'+montant_tva_total+' €</th> </tr>');
                      
                    
                    $('.resume_devis').html(resume_devis.join(" "));
                    
                    if (y > 1 && quantite_diff > 0)
                        $("#pal" + y + '').hide();
                    if (quantite_diff > 0)
                        y++;
                        
                    if (quantite_diff < 0) {
                        quantite_diff = 0;
                    }
                 
                  
                    $(wrapper).append('<div class = "row gy-2 gx-2 align-items-center field' + y +
                        '"> <div class="col-auto"><label for="produit' + y +
                        '">Produit: </label> <select class="form-control select2 liste_produits select_produit" width="80px" required id="produit' + y + '" name="produit' + y +
                        '"> <option></option>'+liste_produits+'</select> </div><div class="col-auto"><label for="quantite' + y +
                        '">Quantité: </label> <input class="form-control quantite" type="number"  min="1" value="1" id="quantite' + y +
                        '" name="quantite' + y +
                        '"/> </div> <div class="col-auto"><label for="prix_ht' + y +
                        '">Prix HT (€): </label> <input class="form-control prix_ht" type="number" value="' +
                        prix_ht + '" id="prix_ht' + y + '" name="prix_ht' + y +
                        '" ></div> <div class="col-auto"><label for="tva' + y +
                        '">Tva: </label> <select class="form-select liste_tvas tva" width="80px" id="tva' + y + '" name="tva' + y +
                        '"> <option></option>'+liste_tvas+'</select> </div>  <div class="col-auto"> <button href="#" id="pal' + y +
                        '" class="btn btn-danger remove_field">Enlever</button></div></br></div>'
                    ); //add input box
                    
                     // Réinitialiser le plugin select2 pour le nouveau champ ajouté
              
                     $('#produit' + y).select2();
                    
                    
                    
                 
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
    </script>

    {{-- Fin pack Expert --}}

    {{-- Envoi des données en ajax pour le stockage --}}
    <script>
        $('.form-valide3').submit(function(e) {
            e.preventDefault();
            var form = $(".form-valide3");


            var palierdata = $('#palier_starter input').serialize();

            data = {

                "palier": $('#palier input').serialize(),
    

            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                type: "POST",
                url: "{{ route('devis.create') }}",

                data: data,
                success: function(data) {
                    console.log(data);

                    swal(
                            'Ajouté',
                            'Le devi a été ajouté avec succés!',
                            'success'
                        )
                        .then(function() {
                            window.location.href = "";
                        })

                },
                error: function(data) {
                    console.log(data);

                    swal(
                        'Echec',
                        'Le devi  n\'a pas été ajouté!',
                        'error'
                    );
                }
            });
        });
    </script>

@endsection
