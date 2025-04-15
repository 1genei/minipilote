@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <style>
        body {
            font-size: 14px;
        }
        /* Style pour les tâches à faire */
        .task-todo {
            background-color: rgba(255, 193, 7, 0.05);
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
                            <li class="breadcrumb-item"><a href="{{ route('agenda.index') }}">Agenda</a></li>
                            <li class="breadcrumb-item active">Tâches à faire</li>
                        </ol>
                    </div>
                    <h4 class="page-title text-warning">
                        <i class="mdi mdi-calendar-check me-1"></i> Tâches à faire
                    </h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

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



                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="media">


                                        <div style="display:flex; flex-direction: row; justify-content:space-around; ">

                                          

                                            <div class="media-left media-middle">
                                                <i class="ti-list f-s-48 color-success m-r-1"></i> <label for=""><a
                                                        style="font-weight: bold; color:#14893f; font-size:18px "
                                                        href="{{ route('agenda.listing_a_faire') }}">Tâches à faire
                                                        <span
                                                            class="badge bg-danger rounded-pill">{{ \App\Models\Agenda::nb_taches('a_faire') }}</span>
                                                    </a></label>
                                                <hr style="border-top: 5px solid #240c9a; margin-top: 10px">
                                            </div>


                                            <div class="media-left media-middle">
                                                <i class="ti-list f-s-48 color-danger m-r-1"></i> <label for=""><a
                                                        style="font-weight: bold; color:#8b0f06;"
                                                        href="{{ route('agenda.listing_en_retard') }}">Tâches en retard
                                                        <span
                                                            class="badge bg-danger rounded-pill">{{ \App\Models\Agenda::nb_taches('en_retard') }}</span>
                                                    </a></label>
                                            </div>
                                            
                                            
                                            <div class="media-left media-middle">
                                                <i class="ti-list f-s-48 color-primary m-r-1"></i> <label for=""><a
                                                        style="font-weight: bold; color:#2483ac; "
                                                        href="{{ route('agenda.listing') }}">Toutes les tâches
                                                        <span
                                                            class="badge bg-danger rounded-pill">{{ \App\Models\Agenda::nb_taches('toutes') }}</span>
                                                    </a></label>
                                            </div>

                                        </div>

                                        <div class="col-lg-12">
                                            <div class="card alert">

                                                <div class="recent-comment ">



                                                    <div class="table-responsive" style="overflow-x: inherit !important;">
                                                        <table
                                                            class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap"
                                                            id="tab1">
                                                            <thead class="table-secondary">

                                                                <tr>
                                                                    <th>Tâche créée par</th>
                                                                    <th>Contact</th>
                                                                    <th>Type</th>
                                                                    <th>Tâche</th>
                                                                    {{-- <th>Tâche</th> --}}
                                                                    <th>Date prévue de réalisation</th>
                                                                    <th>Statut</th>
                                                                    <th>Action</th>


                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                @foreach ($agendas as $agenda)
                                                                    <tr>

                                                                        <td style="color: #450854; ">
                                                                            <span>
                                                                                @if ($agenda->user != null)
                                                                                    {{ $agenda->user->contact?->infos()->prenom }}
                                                                                    {{ $agenda->user->contact?->infos()->nom }}
                                                                                @endif
                                                                            </span>
                                                                        </td>

                                                                        <td style="color: #450854; ">
                                                                            <span>
                                                                                @if ($agenda->est_lie == true && $agenda->contact)
                                                                                    @if ($agenda->contact->type == 'individu')
                                                                                        {{ $agenda->contact->individu->nom }}
                                                                                        {{ $agenda->contact->individu->prenom }}
                                                                                    @else
                                                                                        {{ $agenda->contact->entite->nom }}
                                                                                    @endif
                                                                                @endif

                                                                            </span>
                                                                        </td>

                                                                        <td style="color: #450854; ">
                                                                            <p class="media-heading">
                                                                                {{ $agenda->type_rappel }} </p>
                                                                        </td>
                                                                        <td>
                                                                            <p style="color: #e05555; font-weight:bold; ">
                                                                                {{ $agenda->titre }} </p>
                                                                            <p> <i>{{ $agenda->description }} </i> </p>
                                                                        </td>

                                                                        <td style="color: #32ade1;">
                                                                            @php
                                                                                $date_deb = new DateTime($agenda->date_deb);
                                                                            @endphp
                                                                            <p class="" style="font-weight: bold;">
                                                                                {{ $date_deb->format('d/m/Y') }} à
                                                                                {{ $agenda->heure_deb }}</p>
                                                                        </td>

                                                                        <td style="color: #32ade1;">
                                                                            <div class="comment-action">
                                                                                @if ($agenda->est_terminee == true)
                                                                                    <div class="badge bg-success">Terminée
                                                                                    </div>
                                                                                @else
                                                                                    <div class="badge bg-danger">Non
                                                                                        Terminée</div>
                                                                                @endif
                                                                            </div>

                                                                        </td>

                                                                        <td>
                                                                            @can('permission', 'modifier-agenda')
                                                                                <a data-href="{{ route('agenda.update', $agenda->id) }}"
                                                                                    href="javascript:void(0);"
                                                                                    data-titre="{{ $agenda->titre }}"
                                                                                    data-description="{{ $agenda->description }}"
                                                                                    data-date_deb="{{ $agenda->date_deb }}"
                                                                                    data-date_fin="{{ $agenda->date_fin }}"
                                                                                    data-heure_deb="{{ $agenda->heure_deb }}"
                                                                                    data-type="{{ $agenda->type_rappel }}"
                                                                                    data-est_terminee="{{ $agenda->est_terminee }} "
                                                                                    data-est_lie="{{ $agenda->est_lie }} "
                                                                                    data-contact_id="{{ $agenda->contact_id }}"
                                                                                    title="@lang('Modifier ')"
                                                                                    title="@lang('modifier la tâche ') "
                                                                                    class="modifier text-success"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#modifier-modal"><i
                                                                                        class="mdi mdi-circle-edit-outline"></i>
                                                                                </a>
                                                                            @endcan
                                                                            @can('permission', 'supprimer-agenda')
                                                                                <a href="javascript:void(0);"
                                                                                    data-href="{{ route('agenda.destroy', $agenda->id) }}"
                                                                                    class="delete text-danger"
                                                                                    data-toggle="tooltip"
                                                                                    title="@lang('Supprimer la tâche') "><i
                                                                                        class="mdi mdi-delete-circle-outline"></i>
                                                                                </a>
                                                                            @endcan
                                                                        </td>

                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
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

        {{-- Ajout d'une tâche --}}
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

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="time" name="heure_deb" min="06:00" max="23:00"
                                            value="{{ old('heure_deb') ? old('heure_deb') : '' }}" class="form-control"
                                            id="heure_deb" required>
                                        <label for="heure_deb">Heure de début </label>
                                        @if ($errors->has('heure_deb'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('heure_deb') }}</strong>
                                            </div>
                                        @endif
                                    </div>
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

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="time" name="heure_deb" min="06:00" max="23:00"
                                            value="{{ old('heure_deb') ? old('heure_deb') : '' }}" class="form-control"
                                            id="edit_heure_deb" required>
                                        <label for="edit_heure_deb">Heure de début </label>
                                        @if ($errors->has('heure_deb'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>{{ $errors->first('heure_deb') }}</strong>
                                            </div>
                                        @endif
                                    </div>
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
        $('.modifier').on('click', function(e) {

            let that = $(this);

            $('#edit_titre').val(that.data('titre'));
            $('#edit_description').val(that.data('description'));


            $('#edit_date_deb').val(that.data('date_deb'));
            $('#edit_date_fin').val(that.data('date_fin'));
            $('#edit_heure_deb').val(that.data('heure_deb'));



            let currentFormAction = that.data('href');
            $('#form-edit').attr('action', currentFormAction);




            //    selection du type de tâche
            let currentType = that.data('type');


            let currentEstlie = that.data('est_lie') == true ? "Oui" : "Non";
            let currentEstterminee = that.data('est_terminee') == true ? "Oui" : "Non";

            $('#edit_est_terminee option[value=' + currentEstterminee + ']').attr('selected', 'selected');
            $('#edit_type option[value=' + currentType + ']').attr('selected', 'selected');
            $('#edit_est_lie option[value=' + currentEstlie + ']').attr('selected', 'selected');

            if (currentEstlie == "Oui") {
                let currentContactId = that.data('contact_id');
                $('#edit_contact_id option[value=' + currentContactId + ']').attr('selected', 'selected');
            }


            if (currentEstlie == "Oui") {
                $('.div_contact').show();
                $('#est_lie').attr('required', 'required');

            } else {
                $('.div_contact').hide();

            }

        })

        $('#edit_est_lie').change(function(e) {

            if (e.currentTarget.value == "Oui") {
                $('.div_contact').show();
                $('#est_lie').attr('required', 'required');

            } else {
                $('.div_contact').hide();

            }

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
        $(document).ready(function() {
            "use strict";
            $("#tab1").
            DataTable({
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    },
                    info: "Showing actions _START_ to _END_ of _TOTAL_",
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
                },
                createdRow: function(row, data, dataIndex) {
                    $(row).addClass('task-todo'); // Ajoute une classe pour le style des tâches à faire
                }
            })
        });
    </script>

    @include('partials._sidebar_collapse')
@endsection
