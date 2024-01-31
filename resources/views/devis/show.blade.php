@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'Contact')

@section('content')
<div class="content">
                        
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Contact</a></li>
                     
                    </ol>
                </div>
                <h4 class="page-title">Devis  N° {{ $devis->numero_devis }} </h4>
            </div>
        </div>
        <div class="col-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row g-0">

                        <div class="col-sm-6">

                            <div class="col-sm-4 ">
                                <a href="{{ route('devis.index') }}" type="button" class="btn btn-outline-primary"><i
                                        class="uil-arrow-left"></i>
                                    Devis</a>

                            </div>
                            @if (session('ok'))
                                <div class="col-6">
                                    <div class="alert alert-success alert-dismissible text-center border-0 fade show"
                                        role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong> {{ session('ok') }}</strong>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div> <!-- end row -->
                </div>
            </div> <!-- end card-box-->
        </div>
    </div>
    <!-- end page title --> 

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card text-center">
                <div class="card-body">
                    <h4 class="mb-0 mt-2 text-info">Client/Prospect</h4> <hr>
                 @if($contact->type == "individu")
                    <h4 class=" mt-2">{{ $contact->individu?->civilite }} {{ $contact->individu?->nom }} {{ $contact->individu?->prenom }}</h4>

                    <div class="text-start mt-3">
                        
                        <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ms-2 ">{{ $contact->individu?->email }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Téléphone Fixe :</strong> 
                            <span class="ms-2 "> @if($contact->individu?->telephone_fixe!= null) {{ $contact->individu?->indicatif_fixe }} {{ $contact->individu?->telephone_fixe }} @endif</span>
                        </p>
                        <p class="text-muted mb-2 font-13"><strong>Téléphone Mobile :</strong> 
                            <span class="ms-2 "> @if($contact->individu?->telephone_mobile!= null) {{ $contact->individu?->indicatif_mobile }} {{ $contact->individu?->telephone_mobile }} @endif</span>
                        </p>
                        <p class="text-muted mb-2 font-13"><strong> Adresse :</strong> 
                            <span class="ms-2 "> {{$contact->individu?->numero_voie}} {{$contact->individu?->nom_voie }} {{$contact->individu?->complement_voie }}, {{$contact->individu?->code_postal }}, {{$contact->individu?->ville }} </span>
                        </p>
                        
                       
                    </div>

                @else 
                
                <p class="text-muted font-14">{{ $contact->entite?->forme_juridique }}</p>
                    <h4 class="mb-0 mt-2">{{ $contact->entite?->raison_sociale }} </h4>

                    

                    <div class="text-start mt-3">
                        
                        <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ms-2 ">{{ $contact->entite?->email }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Téléphone Fixe :</strong> 
                            <span class="ms-2 "> @if($contact->entite?->telephone_fixe!= null) {{ $contact->entite?->indicatif_fixe }} {{ $contact->entite?->telephone_fixe }} @endif</span>
                        </p>
                        <p class="text-muted mb-2 font-13"><strong>Téléphone Mobile :</strong> 
                            <span class="ms-2 "> @if($contact->entite?->telephone_mobile!= null) {{ $contact->entite?->indicatif_mobile }} {{ $contact->entite?->telephone_mobile }} @endif</span>
                        </p>
                        <p class="text-muted mb-2 font-13"><strong> Adresse :</strong> 
                            <span class="ms-2 "> {{$contact->entite?->numero_voie}} {{$contact->entite?->nom_voie }} {{$contact->entite?->complement_voie }}, {{$contact->entite?->code_postal }}, {{$contact->entite?->ville }} </span>
                        </p>
       
                    </div>
                @endif
                  
                </div> <!-- end card-body -->
            </div> <!-- end card -->

            <!-- Messages-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="header-title"></h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                           
                            </div>
                        </div>
                    </div>


                </div> <!-- end card-body-->
            </div> <!-- end card-->

        </div> <!-- end col-->

        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    
                    <div class="tab-content">
                        
                     
                        <div class="tab-pane show active" id="activite">
                          
                            <div class="col-lg-9">
                                <a href="{{route('devis.telecharger', Crypt::encrypt($devis->id))}}" type="button"  class="btn btn-danger"><i class="mdi mdi-download me-1"></i> <span>Télécharger</span> </a>
                                <a href="{{route('devis.envoyer_mail', Crypt::encrypt($devis->id))}}" type="button"  class="btn btn-success ms-5"><i class="mdi mdi-email me-1"></i> <span>Envoyer</span> </a>
                                
                                <div class="border p-3 mt-4 mt-lg-0 rounded">
                                
                                <h4 class="header-title mb-3">Devis N° {{$devis->numero_devis}} / <span class="fw-bold">{{$devis->nom_devis}}</span> <a href="{{ route('devis.edit', Crypt::encrypt($devis->id)) }}" class="text-muted"><i class="mdi mdi-square-edit-outline ms-2"></i></a> </h4>

                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <tbody>
                                                
                                                <th>
                                                    <th>Produit :</th>
                                                    <th>Montant TTC</th>
                                                    <th>Montant TVA</th>
                                                </th>
                                                
                                            </tbody>
                                        </table>
                                        
                                        <table class="table mb-0">
                                            <tbody class="resume_devis">
                                                
                                                @foreach($paliers as $key => $palier)
                                                    @php 
                                                        $key++;
                                                       
                                                        $montant_reduction = 0;
                                                        if($palier[4] == "pourcentage"){
                                                            $montant_reduction = $palier[2] * $palier[1] * $palier[5] / 100;
                                                        }else if($palier[4] == "montant"){
                                                            $montant_reduction = $palier[5];
                                                        }
                                                        
                                                    @endphp
                                                    
                                                    
                                                    @if($palier[0] != "")
                                                        <tr>
                                                            <td>{{ $tab_produits[$palier[0]]->nom }} x {{ $palier[1] }}</td>
                                                            <td>{{ $palier[2] * $palier[1] * (1 + $tab_tvas[$palier[3]] / 100) }} @if($montant_reduction != 0) <span class="text-danger"> (-{{number_format($montant_reduction,2)}})</span> @endif </td>
                                                            <td>{{ $palier[2] * $palier[1] * $tab_tvas[$palier[3]] / 100 }} </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                <tr style="background-color: #f1f3fa;font-size: 13px; font-weight: bold;"><th>Total TTC :</td><td class="total_ttc"> {{$devis->montant_ttc}} </th><th></th> </tr>
                                                <tr style="background-color: #f1f3fa;font-size: 13px; font-weight: bold;"><th>Total TVA :</td><td class="">{{$devis->montant_tva}} </th><th></th> </tr>
                                                <tr style="background-color: #f1f3fa;font-size: 13px; font-weight: bold;"><th>Réduction :</td><td class="text-danger total_reduction"> - {{$devis->montant_remise}} </th><th></th> </tr>
                                                <tr style="background-color: #f1f3fa;font-size: 15px; font-weight: bold;border:2px solid #ff5b5b"><th>NET À PAYER :</td><td class="net_a_payer"> {{$devis->net_a_payer}} €</th> <th></th> </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- end table-responsive -->
                                </div>

                               <div class="row">                               
                                    <div class="col-auto">
                                        <label for="type_reduction_globale">Réduction: </label>
                                    
                                        <select class="form-select type_reduction_globale" id="type_reduction_globale" name="type_reduction_globale" readonly>
                                            <option> </option>
                                           <option @if($devis->type_remise == "pourcentage") selected @endif value="pourcentage">%</option>
                                           <option @if($devis->type_remise == "montant") selected @endif value="montant">EUR</option>
                                     
                                        </select>
                                    </div>
                                   
                                    <div class="col-auto">
                                        <label for="reduction_globale"> </label>
                                        <input class="form-control reduction_total" type="number" step="0.01" min="0" value="{{$devis->remise}}" id="reduction_globale" name="reduction_globale" 
                                        readonly  >
                                    </div>
                                    
                                    
                               </div>
                               

                            </div> <!-- end col -->
                        </div>

                    </div> <!-- end tab-content -->
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row-->
  
    
</div> <!-- End Content -->

@endsection

@section('script')
    <script src="{{ asset('assets/js/sweetalert2.all.js') }}"></script>


    

@endsection
