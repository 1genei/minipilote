@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/dropzone-custom.css') }}">
@endsection

@section('title', 'Modifier prestation')

@section('content')


    <style>
        .container-gauche {

            display: flex;
            justify-content: flex-end;
            gap: 10px;

        }
    </style>
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('prestation.index') }}">Prestation</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Prestation</h4>
                </div>
            </div>

            <div class="col-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-sm-6">

                                <div class="col-sm-4 ">
                                    <a href="{{ route('prestation.index') }}" type="button" class="btn btn-outline-primary"><i
                                            class="uil-arrow-left"></i>
                                        Prestation</a>

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

                    {{-- Formulaire de modification de la prestation --}}
                       
                    <form action="{{ route('prestation.update', Crypt::encrypt($prestation->id)) }}" method="post">
                        <div class="modal-body">
        
                            @csrf
                        
        
                            <div class="row">
        
                                    <div class="col-6 ">
                                        <div class="mb-3 ">
                                            <label for="numero" class="form-label">
                                                Numéro de la prestations <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" id="numero" name="numero" min="{{$prestation->numero}}"
                                                value="{{$prestation->numero}}" class="form-control" style="font-size: 1.5rem;color: #772e7b;" required>
        
                                            @if ($errors->has('numero'))
                                                <br>
                                                <div class="alert alert-warning text-secondary " role="alert">
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                    <strong>{{ $errors->first('numero') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
           
                               
                                    <div class="col-6 ">
                                        <div class="mb-3 ">
                                            <label for="nom_prestation" class="form-label">
                                                Nom de la prestations <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" id="nom_prestation" name="nom_prestation" style="font-size: 1.5rem;color: #772e7b;"
                                                value="{{$prestation->nom}}" class="form-control" required>
        
                                            @if ($errors->has('nom_prestation'))
                                                <br>
                                                <div class="alert alert-warning text-secondary " role="alert">
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                    <strong>{{ $errors->first('nom_prestation') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>                    
        
                            </div>
                            
                            <div class="row">
        
                                <div class="col-6 ">
                                    <div class=" mb-3">
                                        <label for="methode_paiement" class="form-label">
                                            Méthode de paiement 
                                        </label>
                                        <select name="methode_paiement" id="methode_paiement" class=" form-control select2"
                                            data-toggle="select2" >
                                            <option value="{{$prestation->methode_paiement}}">{{$prestation->methode_paiement}}</option>
                                            <option value="Espèces">Espèces</option>
                                            <option value="Carte bancaire">Carte bancaire</option>
                                            <option value="Virement">Virement</option>
                                            <option value="Chèque">Chèque</option>
                                            <option value="Autre">Autre</option>                                           
                                        </select>
                                        
                                        @if ($errors->has('methode_paiement'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('methode_paiement') }}</strong>
                                            </div>
                                        @endif
                                    </div>
        
                                </div>
        
                           
                                <div class="col-6 ">
                                    <div class="mb-3 ">
                                        <label for="date_prestation" class="form-label">
                                            Date de la prestations 
                                        </label>
                                        <input type="date" id="date_prestation" name="date_prestation" 
                                            value="{{ $prestation->date_prestation }}" class="form-control" >
        
                                        @if ($errors->has('date_prestation'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('date_prestation') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>                    
        
                            </div>
                            
                            <div class="row">
        
                                <div class="col-6 ">
                                    <div class="mb-3 ">
                                        <label for="montant_ttc" class="form-label">
                                            Montant de la prestations (TTC) <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="montant_ttc" name="montant_ttc" step="0.01"
                                            value="{{ $prestation->montant_ttc}}" class="form-control" required>
        
                                        @if ($errors->has('montant_ttc'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('montant_ttc') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>    
                                <div class="col-6">
                                
                                    <div class="mb-3 ">
                                        <label for="notes" class="form-label">
                                            Notes 
                                        </label>
                                        <textarea name="notes" id="notes" rows="5" class="form-control">{{$prestation->notes}}</textarea>
        
                                        @if ($errors->has('notes'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('notes') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    
                                </div>
                                
        
                            </div>
        
        
                            <div class="col-lg-12 client_existant">
                                <div class="row">
                                    <div class="col-6">
                                        <div class=" mb-3">
                                            <label for="client_id" class="form-label">
                                                Sélectionnez le Client <span class="text-danger">*</span>
                                            </label>
                                            <select name="client_id" id="client_id" class=" form-control select2"
                                                data-toggle="select2" >
                                                <option value="{{$prestation->client()?->id}}">
                                                    {{$prestation->client()?->individu->nom}} {{$prestation->client()?->individu->prenom}}</option>
                                                    @foreach ($newcontacts as $newcontact)
                                                        <option value="{{ $newcontact->id }}">
                                                            {{ $newcontact->individu->nom }} {{ $newcontact->individu->prenom }}
                                                        </option>
                                                    @endforeach
                                            </select>
                                            @if ($errors->has('client_id'))
                                                <br>
                                                <div class="alert alert-warning text-secondary " role="alert">
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                    <strong>{{ $errors->first('client_id') }}</strong>
                                                </div>
                                            @endif
                                        </div>
        
        
                                    </div>
                                    
        
                                </div>
        
                            </div>
                            <hr>
        
                           
                            <div class="col-lg-12 contact_existant">
                                <div class="row">
                                    <div class="col-6">
                                        <div class=" mb-3">
                                            <label for="beneficiaire_id" class="form-label">
                                                Sélectionnez le Bénéficiaire <span class="text-danger">*</span>
                                            </label>
                                            <select name="beneficiaire_id" id="beneficiaire_id" class=" form-control select2"
                                                data-toggle="select2" >
                                                <option value="{{$prestation->beneficiaire()?->id}}">
                                                {{$prestation->beneficiaire()?->individu->nom}} {{$prestation->beneficiaire()?->individu->prenom}}</option>
                                                @foreach ($newcontacts as $newcontact)
                                                    <option value="{{ $newcontact->id }}">
                                                        {{ $newcontact->individu->nom }} {{ $newcontact->individu->prenom }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('beneficiaire_id'))
                                                <br>
                                                <div class="alert alert-warning text-secondary " role="alert">
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                    <strong>{{ $errors->first('beneficiaire_id') }}</strong>
                                                </div>
                                            @endif
                                        </div>
        
        
                                    </div>
                                    
        
                                </div>
        
                            </div>
        
        
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Modifier</button>
        
                        </div>
                    </form>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->








    </div> <!-- End Content -->
@endsection

@section('script')



@endsection
