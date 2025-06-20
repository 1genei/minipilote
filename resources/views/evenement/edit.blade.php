@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'Modifier évènement')

@section('content')

    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('evenement.index') }}">Evènements</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Evènements {{ $evenement->nom }}</h4>
                </div>
            </div>

            <div class="col-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-sm-6">

                                <div class="col-sm-4 ">
                                    <a href="{{ route('evenement.index') }}" type="button" class="btn btn-outline-primary"><i class="uil-arrow-left"></i>
                                        Evènements</a>
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
            <div class="col-9">
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
                       
                    <form action="{{ route('evenement.update', Crypt::encrypt($evenement->id)) }}" method="post">
                        <div class="modal-body">
        
                            @csrf
                            <input type="hidden" name="typecontact" value="Bénéficiaire" />
                            <input type="hidden" name="nature" value=" Personne physique" />
                           
        
        
                            <div class="row">
                               
                                <div class="col-6 ">
                                    <div class="mb-3 ">
                                        <label for="nom" class="form-label">
                                            Nom de l'évènement <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="nom" name="nom" style="font-size: 1.5rem;color: #772e7b;"
                                            value="{{ old('nom') ? old('nom') : $evenement->nom }}" class="form-control" required>
    
                                        @if ($errors->has('nom'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('nom') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div> 
                                
                                <div class="col-6">
                                    <div class=" mb-3">
                                        <label for="circuit_id" class="form-label">
                                            Circuit
                                        </label>
                                        <select name="circuit_id" id="circuit_id" class=" form-control select2"
                                            data-toggle="select2" >
                                            <option value="{{ $evenement->circuit_id }}">{{ $evenement->circuit?->nom }}</option>
                                            @foreach($circuits as $circuit)
                                               <option value="{{ $circuit->id }}">{{ $circuit->nom }}</option>
                                            @endforeach
                                           
                                        </select>
                                        @if ($errors->has('circuit_id'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('circuit_id') }}</strong>
                                            </div>
                                        @endif
                                    </div>
        
                                </div>
        
                            </div>
                            
                            <div class="row">
        
                                <div class="col-6 ">
                                    <div class="mb-3 ">
                                        <label for="date_debut" class="form-label">
                                            Date de début  <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" id="date_debut" name="date_debut"  required
                                            value="{{ old('date_debut') ? old('date_debut') : $evenement->date_debut }}" class="form-control" >
        
                                        @if ($errors->has('date_debut'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('date_debut') }}</strong>
                                            </div>
                                        @endif
                                    </div>
        
                                </div>
        
                           
                                <div class="col-6 ">
                                    <div class="mb-3 ">
                                        <label for="date_fin" class="form-label">
                                            Date de fin <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" id="date_fin" name="date_fin" required
                                            value="{{ old('date_fin') ? old('date_fin') : $evenement->date_fin }}" class="form-control" >
        
                                        @if ($errors->has('date_fin'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('date_fin') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>                    
        
                            </div>
                            
                            <div class="row">
        
                           
                                
                                <div class="col-6">
                                
                                    <div class="mb-3 ">
                                        <label for="description" class="form-label">
                                            Description 
                                        </label>
                                        <textarea name="description" id="description" rows="5" class="form-control"> {{ old('description') ? old('description') : $evenement->description }} </textarea>
        
                                        @if ($errors->has('description'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    
                                </div>                                
                                
        
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="instructeurs" class="form-label">Instructeurs</label>
                                        <select name="instructeurs[]" id="instructeurs" class="form-control select2" multiple>
                                            @foreach($instructeurs as $instructeur)
                                                <option value="{{ $instructeur->id }}"
                                                    @if(collect(old('instructeurs', $evenement->contacts->pluck('id')->toArray()))->contains($instructeur->id)) selected @endif>
                                                    {{ $instructeur->individu->prenom ?? '' }} {{ $instructeur->individu->nom ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="voitures" class="form-label">Véhicules</label>
                                        <select name="voitures[]" id="voitures" class="form-control select2" multiple>
                                            @foreach($voitures as $voiture)
                                                <option value="{{ $voiture->id }}"
                                                    @if(collect(old('voitures', $evenement->voitures->pluck('id')->toArray()))->contains($voiture->id)) selected @endif>
                                                    {{ $voiture->nom }}
                                                </option>
                                            @endforeach
                                        </select>
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

<script src="{{ asset('assets/js/sweetalert2.all.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#instructeurs').select2({
            placeholder: 'Sélectionnez un ou plusieurs instructeurs',
            allowClear: true,
            width: '100%'
        });
        
        $('#voitures').select2({
            placeholder: 'Sélectionnez un ou plusieurs véhicules',
            allowClear: true,
            width: '100%'
        });
    });
</script>

@endsection
