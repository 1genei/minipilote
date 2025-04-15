@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <style>
        /* Forcer l'affichage de toutes les colonnes */
        .table-responsive {
            overflow-x: auto !important;
            min-width: 100%;
        }
        
        /* Définir des largeurs minimales pour certaines colonnes */
        .table th, .table td {
            white-space: normal; /* Permettre le retour à la ligne */
            min-width: 100px; /* Largeur minimale par défaut */
        }
        
        /* Largeurs spécifiques pour certaines colonnes */
        .table th.col-statut, .table td.col-statut { min-width: 100px; }
        .table th.col-priorite, .table td.col-priorite { min-width: 80px; }
        .table th.col-titre, .table td.col-titre { min-width: 250px; }
        .table th.col-contact, .table td.col-contact { min-width: 200px; }
        .table th.col-assigne, .table td.col-assigne { min-width: 200px; }
        .table th.col-date, .table td.col-date { min-width: 150px; }
        .table th.col-actions, .table td.col-actions { min-width: 100px; }

        /* Styles pour les flèches de tri */
        th.sortable {
            cursor: pointer;
            position: relative;
            padding-right: 20px !important;
        }

        th.sortable:before,
        th.sortable:after {
            content: '';
            position: absolute;
            right: 8px;
            width: 0;
            height: 0;
            border-style: solid;
        }

        th.sortable:before {
            top: 40%;
            border-width: 0 4px 4px;
            border-color: transparent transparent #999 transparent;
        }

        th.sortable:after {
            bottom: 40%;
            border-width: 4px 4px 0;
            border-color: #999 transparent transparent transparent;
        }

        th.sortable.asc:before {
            border-color: transparent transparent #000 transparent;
        }

        th.sortable.desc:after {
            border-color: #000 transparent transparent transparent;
        }
    </style>
@endsection

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="">Tâches </a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Tâches </h4>
                </div>
            </div>
        </div>
        <!-- end page title -->


        <!-- end row-->


        <div class="row">
            <div class="col-lg-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-sm-2 mr-14 ">
                                <a href="{{ route('agenda.index') }}" type="button" class="btn btn-danger"><i
                                        class="uil-calendar-alt"></i> Affichage sur le calendrier</a>
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
            </div> <!-- end col-->
        </div>
        <!-- end row-->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-5">
                                @can('permission', 'ajouter-agenda')
                                    <a href="javascript:void(0);" class="btn btn-primary mb-2" data-bs-toggle="modal"
                                        data-bs-target="#standard-modal"><i class="mdi mdi-plus-circle me-2"></i> Ajouter
                                        tâche
                                    </a>
                                @endcan
                            </div>
                            <div class="col-sm-7">

                            </div><!-- end col-->
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
                                @if ($errors->has('role'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </div>
                                @endif
                                <div id="div-role-message"
                                    class="alert alert-success text-secondary alert-dismissible fade in">
                                    <i class="dripicons-checkmark me-2"></i>
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <a href="#" class="alert-link"><strong> <span
                                                id="role-message"></span></strong></a>
                                </div>

                            </div>
                        </div>



                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <form action="{{ route('agenda.listing') }}" method="GET" class="search-form">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Rechercher..." value="{{ request('search') }}">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="mdi mdi-magnify"></i>
                                        </button>
                                        @if(request('search'))
                                            <a href="{{ route('agenda.listing') }}" class="btn btn-danger">
                                                <i class="mdi mdi-close"></i>
                                            </a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-8">
                                <form action="{{ route('agenda.listing') }}" method="GET" class="d-flex gap-2">
                                    @if(request('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif
                                    
                                    <select name="type_rappel" class="form-select" style="width: auto" onchange="this.form.submit()">
                                        <option value="all">Tous les types</option>
                                        @foreach($types_rappel as $type)
                                            <option value="{{ $type }}" {{ request('type_rappel') == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <select name="priorite" class="form-select" style="width: auto" onchange="this.form.submit()">
                                        <option value="all" {{ request('priorite') == 'all' ? 'selected' : '' }}>Toutes les priorités</option>
                                        <option value="basse" {{ request('priorite') == 'basse' ? 'selected' : '' }}>Priorité basse</option>
                                        <option value="moyenne" {{ request('priorite') == 'moyenne' ? 'selected' : '' }}>Priorité moyenne</option>
                                        <option value="haute" {{ request('priorite') == 'haute' ? 'selected' : '' }}>Priorité haute</option>
                                    </select>

                                    <select name="date_sort" class="form-select" style="width: auto" onchange="this.form.submit()">
                                        <option value="">Trier par date</option>
                                        <option value="asc" {{ request('date_sort') == 'asc' ? 'selected' : '' }}>Date ↑</option>
                                        <option value="desc" {{ request('date_sort') == 'desc' ? 'selected' : '' }}>Date ↓</option>
                                    </select>

                                    @if(request('priorite') || request('date_sort') || request('type_rappel'))
                                        <a href="{{ route('agenda.listing', request('search') ? ['search' => request('search')] : []) }}" 
                                           class="btn btn-danger">
                                            Réinitialiser les filtres
                                        </a>
                                    @endif
                                </form>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-sm-8 text-sm-end">
                                <div class="text-muted">
                                    Affichage de <span class="fw-semibold">{{ $agendas->firstItem() }}</span> 
                                    à <span class="fw-semibold">{{ $agendas->lastItem() }}</span> 
                                    sur <span class="fw-semibold">{{ $agendas->total() }}</span> tâches
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="media">


                                        <div style="display:flex; flex-direction: row; justify-content:space-around; ">

                                            
                                            <div class="media-left media-middle">
                                                <i class="ti-list f-s-48 color-success m-r-1"></i>
                                                <label for="">
                                                    <a style="font-weight: bold; color:#14893f"
                                                        href="{{ route('agenda.listing_a_faire') }}">Tâches à faire
                                                        <span
                                                            class="badge bg-danger rounded-pill">{{ \App\Models\Agenda::nb_taches('a_faire') }}</span>
                                                    </a>
                                                </label>
                                            </div>

                                            <div class="media-left media-middle">
                                                <i class="ti-list f-s-48 color-danger m-r-1"></i>
                                                <label for="">
                                                    <a style="font-weight: bold; color:#8b0f06;"
                                                        href="{{ route('agenda.listing_en_retard') }}">Tâches en retard
                                                        <span
                                                            class="badge bg-danger rounded-pill">{{ \App\Models\Agenda::nb_taches('en_retard') }}</span>
                                                    </a>
                                                </label>
                                            </div>
                                            
                                            <div class="media-left media-middle">
                                                <i class="ti-list f-s-48 color-primary m-r-1"></i>
                                                <label for="">
                                                    <a style="font-weight: bold; color:#2483ac; font-size:18px"
                                                        href="{{ route('agenda.listing') }}">Toutes les tâches
                                                        <span
                                                            class="badge bg-danger rounded-pill ">{{ \App\Models\Agenda::nb_taches('toutes') }}
                                                        </span>

                                                    </a>
                                                </label>
                                                <hr style="border-top: 5px solid #240c9a; margin-top: 10px">
                                            </div>


                                        </div>

                                        <div class="col-lg-12">
                                            <div class="card alert">

                                                <div class="recent-comment ">



                                                    <div class="table-responsive">
                                                        <table class="table table-centered table-hover">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th class="col-statut sortable">Statut</th>
                                                                    <th class="col-date sortable">Date & Heure</th>
                                                                    <th class="col-priorite sortable">Priorité</th>
                                                                    <th class="col-titre sortable">Titre & Description</th>
                                                                    <th class="col-contact sortable">Contact lié</th>
                                                                    @if(in_array(Auth::user()?->role?->nom, ['Admin', 'SuperAdmin']))
                                                                        <th class="col-assigne sortable">Assigné à</th>
                                                                    @endif
                                                                    <th class="col-actions">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($agendas as $agenda)
                                                                    <tr>
                                                                        <td>
                                                                            @if ($agenda->est_terminee)
                                                                                <span class="badge bg-success-subtle text-success">Terminée</span>
                                                                                    @else
                                                                                @if ($agenda->date_deb < date('Y-m-d'))
                                                                                    <span class="badge bg-danger-subtle text-danger">En retard</span>
                                                                                @else
                                                                                    <span class="badge bg-warning-subtle text-warning">À faire</span>
                                                                                    @endif
                                                                                @endif
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex align-items-center">
                                                                                <i class="mdi mdi-calendar me-1 text-muted"></i>
                                                                                <p class="mb-0">{{ \Carbon\Carbon::parse($agenda->date_deb)->format('d/m/Y') }}</p>
                                                                            </div>
                                                                            <div class="d-flex align-items-center mt-1">
                                                                                <i class="mdi mdi-clock-outline me-1 text-muted"></i>
                                                                                <p class="mb-0">{{ $agenda->heure_deb }}</p>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            @switch($agenda->priorite)
                                                                                @case('haute')
                                                                                    <i class="mdi mdi-arrow-up-bold text-danger" data-bs-toggle="tooltip" title="Haute"></i>
                                                                                    @break
                                                                                @case('moyenne')
                                                                                    <i class="mdi mdi-arrow-right-bold text-warning" data-bs-toggle="tooltip" title="Moyenne"></i>
                                                                                    @break
                                                                                @default
                                                                                    <i class="mdi mdi-arrow-down-bold text-success" data-bs-toggle="tooltip" title="Basse"></i>
                                                                            @endswitch
                                                                                <span class="text-muted">{{ $agenda->priorite }}
                                                                                </span>
                                                                        </td>

                                                                        <td>
                                                                            @switch($agenda->type_rappel)
                                                                                @case('rdv')
                                                                                    <span class="badge bg-primary">
                                                                                        <i class="mdi mdi-calendar-clock me-1"></i> Rendez-vous
                                                                                    </span>
                                                                                    @break
                                                                                @case('contacter')
                                                                                    <span class="badge bg-info">
                                                                                        <i class="mdi mdi-phone me-1"></i> À contacter
                                                                                    </span>
                                                                                    @break
                                                                                @case('recontacter')
                                                                                    <span class="badge bg-warning">
                                                                                        <i class="mdi mdi-phone-return me-1"></i> À recontacter
                                                                                    </span>
                                                                                    @break
                                                                                @default
                                                                                    <span class="badge bg-secondary">
                                                                                        <i class="mdi mdi-checkbox-marked-circle-outline me-1"></i> Autre
                                                                                    </span>
                                                                            @endswitch

                                                                            <h6 class="mb-1 mt-2">{{ $agenda->titre }}</h6>
                                                                            <p class="text-muted mb-0">{{ $agenda->description }}</p>
                                                                        </td>

                                                                        <td>
                                                                            @if ($agenda->est_lie && $agenda->contact)
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="flex-shrink-0">
                                                                                        <i class="mdi mdi-account-circle text-muted font-14"></i>
                                                                                    </div>
                                                                                    <div class="flex-grow-1 ms-2">
                                                                                        <h6 class="mt-0 mb-1">
                                                                                            @if ($agenda->contact->type == 'individu')
                                                                                                {{ $agenda->contact->individu?->nom }}
                                                                                                {{ $agenda->contact->individu?->prenom }}
                                                                                @else
                                                                                                {{ $agenda->contact->entite?->raison_sociale }}
                                                                                @endif
                                                                                        </h6>
                                                                                        <p class="text-muted mb-0">
                                                                                            <i class="mdi mdi-phone me-1"></i>
                                                                                            {{ $agenda->contact->individu?->telephone_mobile ?? 'Non renseigné' }}
                                                                                        </p>
                                                                            </div>
                                                                                </div>
                                                                            @else
                                                                                <span class="text-muted">Aucun contact lié</span>
                                                                            @endif
                                                                        </td>
                                                                        @if(in_array(Auth::user()?->role?->nom, ['Admin', 'SuperAdmin']))
                                                                        <td>
                                                                            @if ($agenda->user)
                                                                                <div class="d-flex align-items-center">
                                                                                   
                                                                                    <div class="flex-grow-1 ms-2">
                                                                                        <h6 class="mt-0 mb-1">
                                                                                            {{ $agenda->user->contact?->individu?->prenom ?? '' }}
                                                                                            {{ $agenda->user->contact?->individu?->nom ?? '' }}
                                                                                        </h6>
                                                                                        <p class="text-muted mb-0">
                                                                                            {{ $agenda->user->role?->nom ?? 'Rôle non défini' }}
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            @else
                                                                                <span class="text-muted">Non assigné</span>
                                                                            @endif
                                                                        </td>

                                                                        @endif

                                                                        <td class="table-action">
                                                                            @can('permission', 'modifier-agenda')
                                                                                <a href="javascript:void(0);" 
                                                                                   class="action-icon modifier" 
                                                                                   data-bs-toggle="modal"
                                                                                   data-bs-target="#modifier-modal"
                                                                                   data-href="{{ route('agenda.update', $agenda->id) }}"
                                                                                    data-titre="{{ $agenda->titre }}"
                                                                                    data-description="{{ $agenda->description }}"
                                                                                   data-date_deb="{{ \Carbon\Carbon::parse($agenda->date_deb)->format('Y-m-d') }}"
                                                                                   data-date_fin="{{ \Carbon\Carbon::parse($agenda->date_fin)->format('Y-m-d') }}"
                                                                                    data-heure_deb="{{ $agenda->heure_deb }}"
                                                                                    data-type="{{ $agenda->type_rappel }}"
                                                                                   data-priorite="{{ $agenda->priorite }}"
                                                                                   data-est_lie="{{ $agenda->est_lie }}"
                                                                                   data-est_terminee="{{ $agenda->est_terminee }}"
                                                                                   data-contact_id="{{ $agenda->contact_id }}">
                                                                                    <i class="mdi mdi-square-edit-outline"></i>
                                                                                </a>
                                                                            @endcan

                                                                            @can('permission', 'supprimer-agenda')
                                                                                <a href="javascript:void(0);"
                                                                                   class="action-icon delete text-danger" 
                                                                                   data-href="{{ route('agenda.destroy', $agenda->id) }}">
                                                                                    <i class="mdi mdi-delete"></i>
                                                                                </a>
                                                                            @endcan
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <!-- Pagination Laravel -->
                                                    <div class="d-flex justify-content-center">
                                                        {{ $agendas->links('pagination::bootstrap-5') }}
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- /# card -->
                                        </div>



                                        <hr>


                                    </div>
                                </div>
                            </div>
                        </div>






                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

        <style>
            .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
                width: 100%;

            }

            .btn-light:hover {
                background-color: #ffffff;
                border-color: #f0f3f8;
            }

            .btn-light {
                background-color: #ffffff;
                border-color: #f0f3f8;
                height: calc(3.5rem + 2px);

            }
        </style>

      <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Ajouter une tâche </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('agenda.store') }}" method="post">
                        <div class="modal-body">

                            @csrf

                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" min="{{ date('Y-m-d') }}" name="date_deb"
                                            value="{{ old('date_deb') ? old('date_deb') : '' }}" class="form-control"
                                            id="date_deb" required>
                                        <label for="date_deb">Date de début </label>
                                        @if ($errors->has('date_deb'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('date_deb') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" min="{{ date('Y-m-d') }}" name="date_fin"
                                            value="{{ old('date_fin') ? old('date_fin') : '' }}" class="form-control"
                                            id="date_fin" required>
                                        <label for="date_fin">Date de fin </label>
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
                            <br>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="heure_deb" class="form-label">Heure de début</label>
                                    <input type="time" class="form-control" name="heure_deb" required>
                                            </div>
                                <div class="col-md-6">
                                    <label for="priorite" class="form-label">Priorité</label>
                                    <select class="form-select" name="priorite" required>
                                        <option value="basse">Basse</option>
                                        <option value="moyenne" selected>Moyenne</option>
                                        <option value="haute">Haute</option>
                                    </select>
                                    </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <select name="type_rappel" id="edit_type" class="form-select">
                                            <option value="contacter">contacter</option>
                                            <option value="recontacter">recontacter</option>
                                            <option value="rdv">rdv</option>
                                            <option value="autre">autre</option>
                                        </select>
                                        <label for="floatingInput">Type de tâche</label>
                                        @if ($errors->has('type_rappel'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('type_rappel') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>


                            <hr>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <select name="est_lie" id="est_lie" class="form-select">
                                            <option value="Non">Non</option>
                                            <option value="Oui">Oui</option>

                                        </select>
                                        <label for="est_lie">Tâche liée à un contact</label>
                                        @if ($errors->has('est_lie'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('est_lie') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-6 div_contact">
                                    <div class="form-floating mb-3" style="width: 100%;">
                                        <select name="contact_id" id="edit-contact-id" class="selectpicker"
                                            data-live-search="true">
                                            <option value="">Choisir le contact</option>
                                            @foreach ($contacts as $contact)
                                                <option
                                                    data-tokens="@if ($contact->type == 'individu') {{ $contact->infos()?->nom }} {{ $contact->infos()?->prenom }}  @else  {{ $contact->infos()?->nom }} @endif"
                                                    value="{{ $contact->id }}">
                                                    @if ($contact->type == 'individu')
                                                        {{ $contact->infos()?->nom }} {{ $contact->infos()?->prenom }}
                                                    @else
                                                        {{ $contact->infos()?->nom }}
                                                    @endif
                                                </option>
                                            @endforeach


                                        </select>
                                        {{-- <label for="edit-contact-id">Choisir le contact</label> --}}
                                        @if ($errors->has('contact_id'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('contact_id') }}</strong>
                                            </div>
                                        @endif
                                    </div>




                                </div>
                            </div>
                            <br>



                            <div class="row">

                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="titre"
                                            value="{{ old('titre') ? old('titre') : '' }}" class="form-control"
                                            id="titre">
                                        <label for="titre">Titre</label>
                                        @if ($errors->has('titre'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('titre') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>



                            <div class="row">

                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <textarea name="description" id="description" style="height: 100px;" class="form-control">{{ old('description') ? old('description') : '' }}</textarea>
                                        <label for="description">Description de la tâche</label>
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



                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>

                        </div>
                    </form>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->




        {{-- Modification d'une tâche --}}
        <div id="modifier-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Modifier la tâche </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="" id="form-edit" method="post">
                        <div class="modal-body">

                            @csrf

                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="date_deb"
                                            value="{{ old('date_deb') ? old('date_deb') : '' }}" class="form-control"
                                            id="edit_date_deb" required>
                                        <label for="edit_date_deb">Date de début </label>
                                        @if ($errors->has('date_deb'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('date_deb') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="date_fin"
                                            value="{{ old('date_fin') ? old('date_fin') : '' }}" class="form-control"
                                            id="edit_date_fin" required>
                                        <label for="edit_date_fin">Date de fin </label>
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
                            <br>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="heure_deb" class="form-label">Heure de début</label>
                                    <input type="time" class="form-control" name="heure_deb" id="heure_deb_mod" required>
                                            </div>
                                <div class="col-md-6">
                                    <label for="priorite" class="form-label">Priorité</label>
                                    <select class="form-select" name="priorite" id="priorite_mod" required>
                                        <option value="basse">Basse</option>
                                        <option value="moyenne">Moyenne</option>
                                        <option value="haute">Haute</option>
                                    </select>
                                    </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <select name="type_rappel" id="edit_type" class="form-select">
                                            <option value="contacter">contacter</option>
                                            <option value="recontacter">recontacter</option>
                                            <option value="rdv">rdv</option>
                                            <option value="autre">autre</option>
                                        </select>
                                        <label for="edit_type">Type de tâche</label>
                                        @if ($errors->has('type_rappel'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('type_rappel') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <select name="est_terminee" id="edit_est_terminee" class="form-select">
                                            <option value="Oui">Oui</option>
                                            <option value="Non">Non</option>
                                        </select>
                                        <label for="est_terminee" class="text-danger">Tâche Terminée ?</label>
                                        @if ($errors->has('est_terminee'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('est_terminee') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>



                            </div>


                            <hr>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <select name="est_lie" id="edit_est_lie" class="form-select">
                                            <option value="Non">Non</option>
                                            <option value="Oui">Oui</option>

                                        </select>
                                        <label for="edit_est_lie">Tâche liée à un contact</label>
                                        @if ($errors->has('est_lie'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('est_lie') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-6 div_contact">
                                    <div class="form-floating mb-3" style="width: 100%;">
                                        <select name="contact_id" id="edit_contact_id" class="form-select">
                                            <option value="">Choisir le contact</option>
                                            @foreach ($contacts as $contact)
                                                <option value="{{ $contact->id }}">
                                                    @if ($contact->type == 'individu')
                                                        {{ $contact->individu?->nom }} {{ $contact->individu?->prenom }}
                                                    @else
                                                        {{ $contact->entite?->raison_sociale }}
                                                    @endif
                                                </option>
                                            @endforeach


                                        </select>
                                        {{-- <label for="edit-contact-id">Choisir le contact</label> --}}
                                        @if ($errors->has('contact_id'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('contact_id') }}</strong>
                                            </div>
                                        @endif
                                    </div>




                                </div>
                            </div>
                            <br>



                            <div class="row">

                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="titre"
                                            value="{{ old('titre') ? old('titre') : '' }}" class="form-control"
                                            id="edit_titre">
                                        <label for="edit_titre">Titre</label>
                                        @if ($errors->has('titre'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('titre') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>



                            <div class="row">

                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <textarea name="description" id="edit_description" style="height: 100px;" class="form-control">{{ old('description') ? old('description') : '' }}</textarea>
                                        <label for="edit_description">Description de la tâche</label>
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



                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>

                        </div>
                    </form>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


    </div> <!-- End Content -->
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/i18n/defaults-fr_FR.js"></script>

    {{-- Modification d'une tâche --}}
    <script>
        $(document).ready(function() {
            // ... autres scripts ...

            // Gestion du modal de modification
            $('.modifier').click(function() {
                var that = $(this);
                $('#titre_mod').val(that.attr('data-titre'));
                $('#description_mod').val(that.attr('data-description'));
                $('#date_deb_mod').val(that.attr('data-date_deb'));
                $('#date_fin_mod').val(that.attr('data-date_fin'));
                $('#heure_deb_mod').val(that.attr('data-heure_deb'));
                $('#type_rappel_mod').val(that.attr('data-type'));
                $('#priorite_mod').val(that.attr('data-priorite'));
                $('#est_lie_mod').val(that.attr('data-est_lie') == '1' ? 'Oui' : 'Non');
                $('#est_terminee_mod').val(that.attr('data-est_terminee') == '1' ? 'Oui' : 'Non');
                $('#contact_id_mod').val(that.attr('data-contact_id'));
                $('#form-edit').attr('action', that.attr('data-href'));
            });
        });
    </script>



    <script>
        // Choix du contact lie
        $('.div_contact').hide();

        $('#est_lie').change(function(e) {

            if (e.currentTarget.value == "Oui") {
                $('.div_contact').show();
                $('#est_lie').attr('required', 'required');

            } else {
                $('.div_contact').hide();

            }

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
            $('body').on('click', 'a.delete', function(event) {
                let that = $(this)
                event.preventDefault();

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Supprimer',
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
                                type: 'PUT',
                                success: function(data) {
                                    // document.location.reload();
                                },
                                error: function(data) {
                                    console.log(data);
                                }
                            })
                            .done(function() {

                                swalWithBootstrapButtons.fire(
                                    'Supprimée',
                                    '',
                                    'success'
                                )
                                document.location.reload();

                                // that.parents('tr').remove();
                            })


                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Annulée',
                            'Tâche non supprimée :)',
                            'error'
                        )
                    }
                });
            })

        });
    </script>


    <script src="{{ asset('assets/js/sweetalert2.all.js') }}"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const getCellValue = (tr, idx) => {
                const cell = tr.children[idx];
                return cell ? cell.innerText || cell.textContent : '';
            };

            const comparer = (idx, asc) => (a, b) => {
                const v1 = getCellValue(asc ? a : b, idx);
                const v2 = getCellValue(asc ? b : a, idx);
                return v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) 
                    ? v1 - v2 
                    : v1.toString().localeCompare(v2);
            };

            document.querySelectorAll('th.sortable').forEach(th => {
                th.addEventListener('click', () => {
                    const table = th.closest('table');
                    const tbody = table.querySelector('tbody');
                    const rows = Array.from(tbody.querySelectorAll('tr'));
                    const index = Array.from(th.parentElement.children).indexOf(th);
                    
                    // Réinitialiser les autres colonnes
                    th.parentElement.querySelectorAll('th').forEach(header => {
                        if (header !== th) {
                            header.classList.remove('asc', 'desc');
                        }
                    });
                    
                    // Changer la direction du tri
                    const isAsc = th.classList.toggle('asc');
                    th.classList.toggle('desc', !isAsc);
                    
                    // Trier les lignes
                    rows.sort(comparer(index, isAsc));
                    tbody.append(...rows);
                });
            });
        });
    </script>

    @include('partials._sidebar_collapse')
@endsection
