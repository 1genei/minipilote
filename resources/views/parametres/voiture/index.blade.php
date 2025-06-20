@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('title', 'Voitures ')

@section('content')
    <div class="content">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('voiture.index') }}">Voitures </a>
                            </li>
                        </ol>
                    </div>
                    <h4 class="page-title">Voitures</h4>
                </div>
            </div>
        </div>

        <style>
            body {

                font-size: 13px;
            }
        </style>
        @include('layouts.nav_parametre')

        <div class="row">
            <div class="col-lg-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">
            
                            @if (session('ok'))
                                <div class="col-6">
                                    <div class="alert alert-success alert-dismissible  text-center border-0 fade show"
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Onglets -->
                        <ul class="nav nav-tabs nav-bordered mb-3">
                            <li class="nav-item">
                                <a href="#voitures" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                    <i class="mdi mdi-car d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Voitures</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#modeles" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                    <i class="mdi mdi-car-multiple d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Modèles de voiture</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Contenu des onglets -->
                        <div class="tab-content">
                            <div class="tab-pane show active" id="voitures">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex justify-content-start">
                                        @can('permission', 'ajouter-voiture')
                                            <a href="#" class="btn btn-primary mb-2" type="button" data-bs-toggle="modal"
                                                data-bs-target="#standard-modal">
                                                <i class="mdi mdi-plus-circle me-2"></i> Ajouter voiture
                                            </a>
                                        @endcan

                                    </div>
                                    <div class="d-flex justify-content-end">
                                        @can('permission', 'archiver-voiture')
                                            <a href="{{ route('voiture.archives') }}" class="btn btn-warning mb-2">
                                                <i class="mdi mdi-archive me-2"></i> Voitures archivées
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        @if (session('message'))
                                            <div class="alert alert-success text-secondary alert-dismissible ">
                                                <i class="dripicons-checkmark me-2"></i>
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <a href="#" class="alert-link"><strong> {{ session('message') }}</strong></a>
                                            </div>
                                        @endif
                                        @if ($errors->has('nom'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                                <strong>{{ $errors->first('nom') }}</strong>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                  
                                <div class="table-responsive">
                                    <table class="table table-centered table-borderless table-hover w-100 dt-responsive "
                                        id="tab1">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nom</th>
                                                <th>Modèle</th>
                                                <th>Coût km</th>
                                                <th>Coefficient</th>
                                                <th>Prix vente km</th>
                                                <th>Seuil alerte km pneu</th>
                                                <th>Seuil alerte km vidange</th>
                                                <th>Seuil alerte km révision</th>
                                                <th>Seuil alerte km courroie</th>
                                                <th>Seuil alerte km frein</th>
                                                <th>Seuil alerte km amortisseur</th>
                                                <th>Statut</th>
                                                <th style="width: 125px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($voitures as $voiture)
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-body fw-bold">{{ $voiture->nom }}</a>
                                                    </td>
                                                    <td>
                                                        {{ $voiture->modele ? $voiture->modele->nom : 'Non défini' }}
                                                    </td>
                                                    <td>
                                                        {{ number_format($voiture->modele?->cout_kilometrique, 2, ',', ' ') }}
                                                    </td>
                                                    <td>
                                                        <a href="#" class="text-body fw-bold">{{ $voiture->modele?->coefficient_prix }}</a>
                                                    </td>
                                                    <td>
                                                        {{ number_format($voiture->modele?->prix_vente_kilometrique, 2, ',', ' ') }}

                                                    </td>
                                                    <td>
                                                        {{ $voiture->modele?->seuil_alerte_km_pneu }}
                                                    </td>
                                                    <td>
                                                        {{ $voiture->modele?->seuil_alerte_km_vidange }}
                                                    </td>
                                                    <td>
                                                        {{ $voiture->modele?->seuil_alerte_km_revision }}
                                                    </td>
                                                    <td>
                                                        {{ $voiture->modele?->seuil_alerte_km_courroie }}
                                                    </td>
                                                    <td>
                                                        {{ $voiture->modele?->seuil_alerte_km_frein }}
                                                    </td>
                                                    <td>
                                                        {{ $voiture->modele?->seuil_alerte_km_amortisseur }}
                                                    </td>
                                                    
                                                    <td>
                                                        @if ($voiture->archive == false)
                                                            <span class="badge bg-success">Actif</span>
                                                        @else
                                                            <span class="badge bg-warning">Archivé</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @can('permission', 'afficher-voiture')
                                                            <a href="{{ route('voiture.show', Crypt::encrypt($voiture->id)) }}"
                                                                class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                                        @endcan
                                                        @can('permission', 'modifier-voiture')
                                                            <a data-href="{{ route('voiture.update', Crypt::encrypt($voiture->id)) }}"
                                                                data-nom="{{ $voiture->nom }}"
                                                                data-modelevoiture_id="{{ $voiture->modelevoiture_id }}"
                                                                data-cout_kilometrique = "{{ $voiture->cout_kilometrique }}"
                                                                data-coefficient_prix = "{{ $voiture->coefficient_prix }}"
                                                                data-seuil_alerte_km_pneu = "{{ $voiture->seuil_alerte_km_pneu }}"
                                                                data-seuil_alerte_km_vidange = "{{ $voiture->seuil_alerte_km_vidange }}"
                                                                data-seuil_alerte_km_revision = "{{ $voiture->seuil_alerte_km_revision }}"
                                                                data-seuil_alerte_km_courroie = "{{ $voiture->seuil_alerte_km_courroie }}"
                                                                data-seuil_alerte_km_frein = "{{ $voiture->seuil_alerte_km_frein }}"
                                                                data-seuil_alerte_km_amortisseur = "{{ $voiture->seuil_alerte_km_amortisseur }}"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit-voiture"
                                                                class="action-icon edit-voiture text-success">
                                                                <i class="mdi mdi-square-edit-outline"></i>
                                                            </a>
                                                        @endcan
                                                        @can('permission', 'archiver-voiture')
                                                            @if ($voiture->archive == false)
                                                                <a data-href="{{ route('voiture.archiver', Crypt::encrypt($voiture->id)) }}"
                                                                    style="cursor: pointer;"
                                                                    class="action-icon archive-voiture text-warning"> <i
                                                                        class="mdi mdi-archive-arrow-down"></i></a>
                                                            @else
                                                                <a data-href="{{ route('voiture.desarchiver', Crypt::encrypt($voiture->id)) }}"
                                                                    style="cursor: pointer;"
                                                                    class="action-icon unarchive-voiture text-success"> <i
                                                                        class="mdi mdi-archive-arrow-up"></i></a>
                                                            @endif
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane" id="modeles">
                                <div class="d-flex justify-content-between mb-2">
                                    <div>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-modele-modal">
                                            <i class="mdi mdi-plus-circle me-2"></i> Ajouter un modèle
                                        </button>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-centered table-borderless table-hover w-100 dt-responsive" id="tab2">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nom du modèle</th>
                                                <th>Coût km</th>
                                                <th>Coefficient</th>
                                                <th>Prix vente km</th>
                                                <th>Seuil alerte km pneu</th>
                                                <th>Seuil alerte km vidange</th>
                                                <th>Seuil alerte km révision</th>
                                                <th>Seuil alerte km courroie</th>
                                                <th>Seuil alerte km frein</th>
                                                <th>Seuil alerte km amortisseur</th>
                                                <th>Statut</th>
                                                <th style="width: 125px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($modeles as $modele)
                                                <tr>
                                                    <td>{{ $modele->nom }}</td>
                                                    <td>{{ number_format($modele->cout_kilometrique, 2, ',', ' ') }}</td>
                                                    <td>{{ $modele->coefficient_prix }}</td>
                                                    <td>{{ number_format($modele->prix_vente_kilometrique, 2, ',', ' ') }}</td>
                                                    <td>{{ $modele->seuil_alerte_km_pneu }}</td>
                                                    <td>{{ $modele->seuil_alerte_km_vidange }}</td>
                                                    <td>{{ $modele->seuil_alerte_km_revision }}</td>
                                                    <td>{{ $modele->seuil_alerte_km_courroie }}</td>
                                                    <td>{{ $modele->seuil_alerte_km_frein }}</td>
                                                    <td>{{ $modele->seuil_alerte_km_amortisseur }}</td>
                                                    <td>
                                                        @if ($modele->archive == false)
                                                            <span class="badge bg-success">Actif</span>
                                                        @else
                                                            <span class="badge bg-warning">Archivé</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="#" class="action-icon edit-modele text-success"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#edit-modele-modal"
                                                            data-id="{{ Crypt::encrypt($modele->id) }}"
                                                            data-nom="{{ $modele->nom }}"
                                                            data-cout_kilometrique="{{ $modele->cout_kilometrique }}"
                                                            data-coefficient_prix="{{ $modele->coefficient_prix }}"
                                                            data-seuil_alerte_km_pneu="{{ $modele->seuil_alerte_km_pneu }}"
                                                            data-seuil_alerte_km_vidange="{{ $modele->seuil_alerte_km_vidange }}"
                                                            data-seuil_alerte_km_revision="{{ $modele->seuil_alerte_km_revision }}"
                                                            data-seuil_alerte_km_courroie="{{ $modele->seuil_alerte_km_courroie }}"
                                                            data-seuil_alerte_km_frein="{{ $modele->seuil_alerte_km_frein }}"
                                                            data-seuil_alerte_km_amortisseur="{{ $modele->seuil_alerte_km_amortisseur }}">
                                                            <i class="mdi mdi-square-edit-outline"></i>
                                                        </a>
                                                        <a href="#" class="action-icon delete-modele text-danger"
                                                            data-href="{{ route('modelevoiture.destroy', Crypt::encrypt($modele->id)) }}">
                                                            <i class="mdi mdi-delete"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ajout d'une voiture --}}
        <div id="standard-modal" class="modal fade" tabindex="-1" voiture="dialog"
            aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-dark">
                        <h4 class="modal-title" id="standard-modalLabel">Ajouter une voiture</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('voiture.store') }}" method="post">
                        <div class="modal-body">

                            @csrf
                            <div class="row" >

                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="nom" value="{{ old('nom') ? old('nom') : '' }}"
                                            class="form-control" id="floatingInput" style="background-color: #f9f0f0;">
                                        <label for="floatingInput">Nom de la Voiture</label>
                                        @if ($errors->has('nom'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " voiture="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('nom') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="modelevoiture_id" name="modelevoiture_id" style="background-color: #f9f0f0;">
                                            <option value="">Sélectionnez un modèle</option>
                                            @foreach($modeles as $modele)
                                                <option value="{{ $modele->id }}" {{ old('modelevoiture_id') == $modele->id ? 'selected' : '' }}>
                                                    {{ $modele->nom }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="modelevoiture_id">Modèle de voiture</label>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="cout_kilometrique"  value="{{ old('cout_kilometrique') ? old('cout_kilometrique') : '' }}"
                                            class="form-control" id="cout_kilometrique" min="0" step="0.01" style="background-color: #f9f0f0;" required >
                                        <label for="cout_kilometrique">Coût au kilométrique</label>
                                        @if ($errors->has('cout_kilometrique'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " voiture="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('cout_kilometrique') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div> --}}
                                {{-- <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="coefficient_prix"  value="{{ old('coefficient_prix') ? old('coefficient_prix') : '' }}"
                                            class="form-control" id="coefficient_prix" min="0" step="0.01" required style="background-color: #f9f0f0;" >
                                        <label for="coefficient_prix">Coefficient</label>
                                        @if ($errors->has('coefficient_prix'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " voiture="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('coefficient_prix') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div> --}}
                                <hr>
                                {{-- <hr>
                                <br> --}}
                                {{-- <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_pneu" value="{{ old('seuil_alerte_km_pneu') ? old('seuil_alerte_km_pneu') : '' }}"
                                            class="form-control" id="seuil_alerte_km_pneu">
                                        <label for="seuil_alerte_km_pneu">Seuil alerte km pneu</label>
                                        @if ($errors->has('seuil_alerte_km_pneu'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " voiture="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('seuil_alerte_km_pneu') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_vidange" value="{{ old('seuil_alerte_km_vidange') ? old('seuil_alerte_km_vidange') : '' }}"
                                            class="form-control" id="seuil_alerte_km_vidange">
                                        <label for="seuil_alerte_km_vidange">Seuil alerte km vidange</label>
                                        @if ($errors->has('seuil_alerte_km_vidange'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " voiture="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('seuil_alerte_km_vidange') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_revision" value="{{ old('seuil_alerte_km_revision') ? old('seuil_alerte_km_revision') : '' }}"
                                            class="form-control" id="seuil_alerte_km_revision">
                                        <label for="seuil_alerte_km_revision">Seuil alerte km révision</label>
                                        @if ($errors->has('seuil_alerte_km_revision'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " voiture="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('seuil_alerte_km_revision') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_courroie" value="{{ old('seuil_alerte_km_courroie') ? old('seuil_alerte_km_courroie') : '' }}"
                                            class="form-control" id="seuil_alerte_km_courroie">
                                        <label for="seuil_alerte_km_courroie">Seuil alerte km courroie</label>
                                        @if ($errors->has('seuil_alerte_km_courroie'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " voiture="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('seuil_alerte_km_courroie') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_frein" value="{{ old('seuil_alerte_km_frein') ? old('seuil_alerte_km_frein') : '' }}"
                                            class="form-control" id="seuil_alerte_km_frein">
                                        <label for="seuil_alerte_km_frein">Seuil alerte km frein</label>
                                        @if ($errors->has('seuil_alerte_km_frein'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " voiture="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('seuil_alerte_km_frein') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_amortisseur" value="{{ old('seuil_alerte_km_amortisseur') ? old('seuil_alerte_km_amortisseur') : '' }}"
                                            class="form-control" id="seuil_alerte_km_amortisseur">
                                        <label for="seuil_alerte_km_amortisseur">Seuil alerte km amortisseur</label>
                                        @if ($errors->has('seuil_alerte_km_amortisseur'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " voiture="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('seuil_alerte_km_amortisseur') }}</strong>
                                            </div>
                                        @endif  
                                        
                                    </div>
                                </div> --}}
                                

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-dark">Enregistrer</button>
                        </div>
                    </form>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->




        {{-- Modification d'une voiture --}}
        <div id="edit-voiture" class="modal fade" tabindex="-1" voiture="dialog"
            aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-dark">
                        <h4 class="modal-title" id="standard-modalLabel">Modification </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="" id="edit_form" method="post">
                        <div class="modal-body">

                            @csrf
                            <div class="row" >

                                <div class="col-lg-6">
                                
                                    <div class="form-floating mb-3">
                                        <input type="text" name="nom" value="{{ old('nom') ? old('nom') : '' }}"
                                            class="form-control" id="edit_nom" style="background-color: #f9f0f0;">
                                        <label for="edit_nom">Nom de la Voiture</label>
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
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="edit_modelevoiture_id" name="modelevoiture_id" style="background-color: #f9f0f0;">
                                            <option value="">Sélectionnez un modèle</option>
                                            @foreach($modeles as $modele)
                                                <option value="{{ $modele->id }}">{{ $modele->nom }}</option>
                                            @endforeach
                                        </select>
                                        <label for="edit_modelevoiture_id">Modèle de voiture</label>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="cout_kilometrique"  value="{{ old('cout_kilometrique') ? old('cout_kilometrique') : '' }}"
                                            class="form-control" id="edit_cout_kilometrique" min="0" step="0.01" style="background-color: #f9f0f0;" required >
                                        <label for="edit_cout_kilometrique">Coût au kilométrique</label>
                                        @if ($errors->has('cout_kilometrique'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " voiture="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('cout_kilometrique') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="coefficient_prix"  value="{{ old('coefficient_prix') ? old('coefficient_prix') : '' }}"
                                            class="form-control" id="edit_coefficient_prix" min="0" step="0.01" required style="background-color: #f9f0f0;" >
                                        <label for="edit_coefficient_prix">Coefficient</label>
                                        @if ($errors->has('coefficient_prix'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " voiture="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('coefficient_prix') }}</strong>
                                            </div>
                                        @endif
                                    </div> 
                                </div>--}}
                                <hr>
                                <hr>
                                <br>
                                
                                {{-- <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_pneu" value="{{ old('seuil_alerte_km_pneu') ? old('seuil_alerte_km_pneu') : '' }}"
                                            class="form-control" id="edit_seuil_alerte_km_pneu">
                                        <label for="edit_seuil_alerte_km_pneu">Seuil alerte km pneu</label>
                                        @if ($errors->has('seuil_alerte_km_pneu'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " voiture="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('seuil_alerte_km_pneu') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_vidange" value="{{ old('seuil_alerte_km_vidange') ? old('seuil_alerte_km_vidange') : '' }}"
                                            class="form-control" id="edit_seuil_alerte_km_vidange">
                                        <label for="edit_seuil_alerte_km_vidange">Seuil alerte km vidange</label>
                                        @if ($errors->has('seuil_alerte_km_vidange'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " voiture="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('seuil_alerte_km_vidange') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_revision" value="{{ old('seuil_alerte_km_revision') ? old('seuil_alerte_km_revision') : '' }}"
                                            class="form-control" id="edit_seuil_alerte_km_revision">
                                        <label for="edit_seuil_alerte_km_revision">Seuil alerte km révision</label>
                                        @if ($errors->has('seuil_alerte_km_revision'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " voiture="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('seuil_alerte_km_revision') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_courroie" value="{{ old('seuil_alerte_km_courroie') ? old('seuil_alerte_km_courroie') : '' }}"
                                            class="form-control" id="edit_seuil_alerte_km_courroie">
                                        <label for="edit_seuil_alerte_km_courroie">Seuil alerte km courroie</label>
                                        @if ($errors->has('seuil_alerte_km_courroie'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " voiture="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('seuil_alerte_km_courroie') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_frein" value="{{ old('seuil_alerte_km_frein') ? old('seuil_alerte_km_frein') : '' }}"
                                            class="form-control" id="edit_seuil_alerte_km_frein">
                                        <label for="edit_seuil_alerte_km_frein">Seuil alerte km frein</label>
                                        @if ($errors->has('seuil_alerte_km_frein'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " voiture="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('seuil_alerte_km_frein') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_amortisseur" value="{{ old('seuil_alerte_km_amortisseur') ? old('seuil_alerte_km_amortisseur') : '' }}"
                                            class="form-control" id="edit_seuil_alerte_km_amortisseur">
                                        <label for="edit_seuil_alerte_km_amortisseur">Seuil alerte km amortisseur</label>
                                        @if ($errors->has('seuil_alerte_km_amortisseur'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " voiture="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('seuil_alerte_km_amortisseur') }}</strong>
                                            </div>
                                        @endif  
                                        
                                    </div>
                                </div> --}}
                                

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-dark">Enregistrer</button>

                        </div>
                    </form>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- Modal d'ajout de modèle -->
        <div class="modal fade" id="add-modele-modal" tabindex="-1" role="dialog" aria-labelledby="add-modele-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-dark">
                        <h4 class="modal-title" id="add-modele-modalLabel">Ajouter un modèle de voiture</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('modelevoiture.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="nom" value="{{ old('nom') }}" class="form-control" id="nom" required>
                                        <label for="nom">Nom du modèle</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="cout_kilometrique" value="{{ old('cout_kilometrique') }}" class="form-control" id="cout_kilometrique_modele" min="0" step="0.01" required>
                                        <label for="cout_kilometrique_modele">Coût au kilométrique</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="coefficient_prix" value="{{ old('coefficient_prix') }}" class="form-control" id="coefficient_prix_modele" min="0" step="0.01" required>
                                        <label for="coefficient_prix_modele">Coefficient</label>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_pneu" value="{{ old('seuil_alerte_km_pneu') }}" class="form-control" id="seuil_alerte_km_pneu_modele">
                                        <label for="seuil_alerte_km_pneu_modele">Seuil alerte km pneu</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_vidange" value="{{ old('seuil_alerte_km_vidange') }}" class="form-control" id="seuil_alerte_km_vidange_modele">
                                        <label for="seuil_alerte_km_vidange_modele">Seuil alerte km vidange</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_revision" value="{{ old('seuil_alerte_km_revision') }}" class="form-control" id="seuil_alerte_km_revision_modele">
                                        <label for="seuil_alerte_km_revision_modele">Seuil alerte km révision</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_courroie" value="{{ old('seuil_alerte_km_courroie') }}" class="form-control" id="seuil_alerte_km_courroie_modele">
                                        <label for="seuil_alerte_km_courroie_modele">Seuil alerte km courroie</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_frein" value="{{ old('seuil_alerte_km_frein') }}" class="form-control" id="seuil_alerte_km_frein_modele">
                                        <label for="seuil_alerte_km_frein_modele">Seuil alerte km frein</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_amortisseur" value="{{ old('seuil_alerte_km_amortisseur') }}" class="form-control" id="seuil_alerte_km_amortisseur_modele">
                                        <label for="seuil_alerte_km_amortisseur_modele">Seuil alerte km amortisseur</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-dark">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal de modification de modèle -->
        <div class="modal fade" id="edit-modele-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modele-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header modal-colored-header bg-dark">
                        <h4 class="modal-title" id="edit-modele-modalLabel">Modifier un modèle de voiture</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="edit-modele-form" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="nom" class="form-control" id="edit_nom_modele" required>
                                        <label for="edit_nom_modele">Nom du modèle</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="cout_kilometrique" class="form-control" id="edit_cout_kilometrique_modele" min="0" step="0.01" required>
                                        <label for="edit_cout_kilometrique_modele">Coût au kilométrique</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="coefficient_prix" class="form-control" id="edit_coefficient_prix_modele" min="0" step="0.01" required>
                                        <label for="edit_coefficient_prix_modele">Coefficient</label>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_pneu" class="form-control" id="edit_seuil_alerte_km_pneu_modele">
                                        <label for="edit_seuil_alerte_km_pneu_modele">Seuil alerte km pneu</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_vidange" class="form-control" id="edit_seuil_alerte_km_vidange_modele">
                                        <label for="edit_seuil_alerte_km_vidange_modele">Seuil alerte km vidange</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_revision" class="form-control" id="edit_seuil_alerte_km_revision_modele">
                                        <label for="edit_seuil_alerte_km_revision_modele">Seuil alerte km révision</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_courroie" class="form-control" id="edit_seuil_alerte_km_courroie_modele">
                                        <label for="edit_seuil_alerte_km_courroie_modele">Seuil alerte km courroie</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_frein" class="form-control" id="edit_seuil_alerte_km_frein_modele">
                                        <label for="edit_seuil_alerte_km_frein_modele">Seuil alerte km frein</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" name="seuil_alerte_km_amortisseur" class="form-control" id="edit_seuil_alerte_km_amortisseur_modele">
                                        <label for="edit_seuil_alerte_km_amortisseur_modele">Seuil alerte km amortisseur</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-dark">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    {{-- Modification d'une voiture --}}
    <script>
        $('.edit-voiture').click(function(e) {
            let that = $(this);
            let currentVoiture = that.data('nom');
            let currentModelevoitureId = that.data('modelevoiture_id');
            let currentCoutKilometrique = that.data('cout_kilometrique');
            let currentCoefficientPrix = that.data('coefficient_prix');
            let currentSeuilAlerteKmPneu = that.data('seuil_alerte_km_pneu');
            let currentSeuilAlerteKmVidange = that.data('seuil_alerte_km_vidange');
            let currentSeuilAlerteKmRevision = that.data('seuil_alerte_km_revision');
            let currentSeuilAlerteKmCourroie = that.data('seuil_alerte_km_courroie');
            let currentSeuilAlerteKmFrein = that.data('seuil_alerte_km_frein');
            let currentSeuilAlerteKmAmortisseur = that.data('seuil_alerte_km_amortisseur');
            let currentFormAction = that.data('href');
            
            $('#edit_nom').val(currentVoiture);
            $('#edit_modelevoiture_id').val(currentModelevoitureId);
            $('#edit_cout_kilometrique').val(currentCoutKilometrique);
            $('#edit_coefficient_prix').val(currentCoefficientPrix);
            $('#edit_seuil_alerte_km_pneu').val(currentSeuilAlerteKmPneu);
            $('#edit_seuil_alerte_km_vidange').val(currentSeuilAlerteKmVidange);
            $('#edit_seuil_alerte_km_revision').val(currentSeuilAlerteKmRevision);
            $('#edit_seuil_alerte_km_courroie').val(currentSeuilAlerteKmCourroie);
            $('#edit_seuil_alerte_km_frein').val(currentSeuilAlerteKmFrein);
            $('#edit_seuil_alerte_km_amortisseur').val(currentSeuilAlerteKmAmortisseur);
            
            $('#edit_form').attr('action', currentFormAction);
        });
    </script>


    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.archive-voiture', function(event) {
                let that = $(this)
                event.preventDefault();

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Archiver',
                    text: "Confirmer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {

                        $('[data-toggle="tooltip"]').tooltip('hide')
                        $.ajax({
                                url: that.attr('data-href'),
                                type: 'POST',
                                success: function(data) {
                                    // document.location.reload();
                                },
                                error: function(data) {
                                    console.log(data);
                                }
                            })
                            .done(function() {

                                swalWithBootstrapButtons.fire(
                                        'Archivée',
                                        '',
                                        'success'
                                    )

                                    .then((result) => {
                                        if (result.isConfirmed) {
                                            document.location.reload();
                                        }
                                    })


                                // that.parents('tr').remove();
                            })


                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Annulé',
                            'Voiture non archivée :)',
                            'error'
                        )
                    }
                });
            })

        });
    </script>

    <script>
        // Désarchiver

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.unarchive-voiture', function(event) {
                let that = $(this)
                event.preventDefault();

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Désarchiver',
                    text: "Confirmer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {

                        $('[data-toggle="tooltip"]').tooltip('hide')
                        $.ajax({
                                url: that.attr('data-href'),
                                type: 'POST',
                                success: function(data) {

                                    // document.location.reload();
                                },
                                error: function(data) {
                                    console.log(data);
                                }
                            })
                            .done(function() {

                                swalWithBootstrapButtons.fire(
                                        'Désarchivée',
                                        '',
                                        'success'
                                    )
                                    .then((result) => {
                                        if (result.isConfirmed) {
                                            document.location.reload();
                                        }
                                    })
                            })


                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Annulé',
                            'Voiture non désarchivée :)',
                            'error'
                        )
                    }
                });
            })

        });
    </script>


    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            "use strict";
            $("#tab1").
            DataTable({
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    },
                    info: "Affichage de  _START_ à _END_ sur _TOTAL_",
                    lengthMenu: 'Afficher <select class=\'form-select form-select-sm ms-1 me-1\'><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="-1">All</option></select> '
                },
                pageLength: 100,

                select: {
                    style: "multi"
                },
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded"),
                        document.querySelector(".dataTables_wrapper .row").querySelectorAll(".col-md-6")
                        .forEach(function(e) {
                            e.classList.add("col-sm-6"), e.classList.remove("col-sm-12"), e
                                .classList.remove("col-md-6")
                        })
                }
            })
        });
    </script>

    <!-- Scripts pour les modèles de voiture -->
    <script>
        // Édition d'un modèle
        $('.edit-modele').click(function(e) {
            let that = $(this);
            let currentId = that.data('id');
            let currentNom = that.data('nom');
            let currentCoutKilometrique = that.data('cout_kilometrique');
            let currentCoefficientPrix = that.data('coefficient_prix');
            let currentSeuilAlerteKmPneu = that.data('seuil_alerte_km_pneu');
            let currentSeuilAlerteKmVidange = that.data('seuil_alerte_km_vidange');
            let currentSeuilAlerteKmRevision = that.data('seuil_alerte_km_revision');
            let currentSeuilAlerteKmCourroie = that.data('seuil_alerte_km_courroie');
            let currentSeuilAlerteKmFrein = that.data('seuil_alerte_km_frein');
            let currentSeuilAlerteKmAmortisseur = that.data('seuil_alerte_km_amortisseur');
            
            $('#edit_nom_modele').val(currentNom);
            $('#edit_cout_kilometrique_modele').val(currentCoutKilometrique);
            $('#edit_coefficient_prix_modele').val(currentCoefficientPrix);
            $('#edit_seuil_alerte_km_pneu_modele').val(currentSeuilAlerteKmPneu);
            $('#edit_seuil_alerte_km_vidange_modele').val(currentSeuilAlerteKmVidange);
            $('#edit_seuil_alerte_km_revision_modele').val(currentSeuilAlerteKmRevision);
            $('#edit_seuil_alerte_km_courroie_modele').val(currentSeuilAlerteKmCourroie);
            $('#edit_seuil_alerte_km_frein_modele').val(currentSeuilAlerteKmFrein);
            $('#edit_seuil_alerte_km_amortisseur_modele').val(currentSeuilAlerteKmAmortisseur);
            
            $('#edit-modele-form').attr('action', '/modelevoiture/update/' + currentId);
        });

        // Suppression d'un modèle
        $('body').on('click', 'a.delete-modele', function(event) {
            let that = $(this);
            event.preventDefault();

            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            });

            swalWithBootstrapButtons.fire({
                title: 'Supprimer',
                text: "Confirmer la suppression ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui',
                cancelButtonText: 'Non',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: that.attr('data-href'),
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            swalWithBootstrapButtons.fire(
                                'Supprimé !',
                                'Le modèle a été supprimé.',
                                'success'
                            ).then(() => {
                                document.location.reload();
                            });
                        },
                        error: function(data) {
                            swalWithBootstrapButtons.fire(
                                'Erreur',
                                'Une erreur est survenue.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        // DataTable pour les modèles
        $("#tab2").DataTable({
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>"
                },
                info: "Affichage de _START_ à _END_ sur _TOTAL_",
                lengthMenu: 'Afficher <select class=\'form-select form-select-sm ms-1 me-1\'><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="-1">Tout</option></select> '
            },
            pageLength: 10,
            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            }
        });
    </script>

@endsection
