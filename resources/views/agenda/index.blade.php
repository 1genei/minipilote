@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
@endsection

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                            <li class="breadcrumb-item active">Calendrier des tâches</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Calendar</h4>
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
                                <a href="{{ route('agenda.listing') }}" type="button" class="btn btn-danger"><i
                                        class="uil-grid"></i> Affichage dans un tableau</a>
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
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="d-grid">
                                    <button class="btn btn-lg font-16 btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#new-event"><i class="mdi mdi-plus-circle-outline"></i> Créer
                                        nouvelle tâche</button>
                                </div>
                                <div id="external-events" class="m-t-20">
                                    <br>

                                </div>

                            </div> <!-- end col-->

                            <div class="col-12">
                                <div class="mt-4 mt-lg-0">
                                    <div id="calendar"></div>
                                </div>
                            </div> <!-- end col -->

                        </div> <!-- end row -->
                    </div> <!-- end card body-->
                </div> <!-- end card -->


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
                <div id="new-event" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="standard-modalLabel">Ajouter une tâche </h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form action="{{ route('agenda.store') }}" method="post">
                                <div class="modal-body">

                                    @csrf

                                    <br>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-floating mb-3">
                                                <input type="date" min="{{ date('Y-m-d') }}" name="date_deb"
                                                    value="{{ old('date_deb') ? old('date_deb') : '' }}"
                                                    class="form-control" id="date_deb" required>
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
                                                    value="{{ old('date_fin') ? old('date_fin') : '' }}"
                                                    class="form-control" id="date_fin" required>
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
                                                    value="{{ old('heure_deb') ? old('heure_deb') : '' }}"
                                                    class="form-control" id="heure_deb" required>
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
                                                <select name="type_rappel" id="type_rappel" class="form-select">
                                                    <option value="appel">appel</option>
                                                    <option value="rappel">rappel</option>
                                                    <option value="rdv">rdv</option>
                                                    <option value="autre">autre</option>
                                                </select>
                                                <label for="type_rappel">Type de tâche</label>
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
                                                <select name="contact_id" id="contact_id" class="selectpicker "
                                                    data-live-search="true">
                                                    <option value="">Choisir le contact</option>
                                                    @foreach ($contacts as $contact)
                                                        <option
                                                            data-tokens="@if ($contact->type == 'individu') {{ $contact->individu->nom }} {{ $contact->individu->prenom }}  @else  {{ $contact->entite->nom }} @endif"
                                                            value="{{ $contact->id }}">
                                                            @if ($contact->type == 'individu')
                                                                {{ $contact->individu->nom }}
                                                                {{ $contact->individu->prenom }}
                                                            @else
                                                                {{ $contact->entite->nom }}
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
                <div id="event-modal" class="modal fade" tabindex="-1" role="dialog"
                    aria-labelledby="standard-modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="standard-modalLabel">Modifier la tâche </h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form action="" id="form-edit" method="post">
                                <div class="modal-body">

                                    @csrf

                                    <br>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-floating mb-3">
                                                <input type="date" min="{{ date('Y-m-d') }}" name="date_deb"
                                                    value="{{ old('date_deb') ? old('date_deb') : '' }}"
                                                    class="form-control" id="edit_date_deb" required>
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
                                                    value="{{ old('date_fin') ? old('date_fin') : '' }}"
                                                    class="form-control" id="edit_date_fin" required>
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
                                                    value="{{ old('heure_deb') ? old('heure_deb') : '' }}"
                                                    class="form-control" id="edit_heure_deb" required>
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
                                                <select name="type_rappel" id="edit_type_rappel" class="form-select">
                                                    <option value="appel">appel</option>
                                                    <option value="rappel">rappel</option>
                                                    <option value="rdv">rdv</option>
                                                    <option value="autre">autre</option>
                                                </select>
                                                <label for="type_rappel">Type de tâche</label>
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

                                        <div class="col-6 div_edit_contact">
                                            <div class="form-floating mb-3" style="width: 100%;">
                                                <select name="contact_id" id="edit_contact_id" class="form-select "
                                                    data-live-search="true">
                                                    <option value="">Choisir le contact</option>
                                                    @foreach ($contacts as $contact)
                                                        <option
                                                            data-tokens="@if ($contact->type == 'individu') {{ $contact->individu->nom }} {{ $contact->individu->prenom }}  @else  {{ $contact->entite->nom }} @endif"
                                                            value="{{ $contact->id }}">
                                                            @if ($contact->type == 'individu')
                                                                {{ $contact->individu->nom }}
                                                                {{ $contact->individu->prenom }}
                                                            @else
                                                                {{ $contact->entite->nom }}
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
                                                <textarea name="description" id="edit_description" style="height: 100px;" class="form-control">{{ old('description') ? old('description') : '' }}</textarea>
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




                <!-- Add New Event MODAL -->
                <div class="modal fade" id="" tabindex="1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form class="needs-validation" name="event-form" id="form-event" novalidate>
                                <div class="modal-header py-3 px-4 border-bottom-0">
                                    <h5 class="modal-title" id="modal-title">Event</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body px-4 pb-4 pt-0">


                                </div>
                            </form>
                        </div> <!-- end modal-content-->
                    </div> <!-- end modal dialog-->
                </div>
                <!-- end modal-->






            </div>
            <!-- end col-12 -->
        </div> <!-- end row -->

    </div> <!-- End Content -->
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{ asset('assets/js/vendor/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/fullcalendar.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/i18n/defaults-fr_FR.js"></script>

    <script>
        var agendas = "{{ $agendas }}";
        agendas = JSON.parse(agendas.replaceAll('&quot;', '"'));
        tab_contacts = "{{ $tab_contacts }}";

        tab_contacts = JSON.parse(tab_contacts.replaceAll('&quot;', '"'));


        !(function(e) {
            "use strict";

            function t() {
                (this.$body = e("body")),
                (this.$modal = new bootstrap.Modal(document.getElementById("event-modal"), {
                    backdrop: "static"
                })),
                (this.$calendar = e("#calendar")),
                (this.$formEvent = e("#form-event")),
                (this.$btnNewEvent = e("#btn-new-event")),
                (this.$btnDeleteEvent = e("#btn-delete-event")),
                (this.$btnSaveEvent = e("#btn-save-event")),
                (this.$modalTitle = e("#modal-title")),
                (this.$calendarObj = null),
                (this.$selectedEvent = null),
                (this.$newEventData = null);
            }
            (t.prototype.onEventClick = function(t) {

                this.$formEvent[0].reset(),
                    this.$formEvent.removeClass("was-validated"),
                    (this.$newEventData = null),
                    this.$btnDeleteEvent.show(),
                    this.$modalTitle.text("Edit Event"),
                    this.$modal.show(),
                    (this.$selectedEvent = t.event),
                    e("#edit_titre").val(this.$selectedEvent.extendedProps.titre),
                    e("#edit_description").val(this.$selectedEvent.extendedProps.description),
                    // e("#type_rappel").val(this.$selectedEvent.extendedProps.type_rappel),
                    e("#edit_date_deb").val(this.$selectedEvent.extendedProps.date_deb),
                    e("#edit_date_fin").val(this.$selectedEvent.extendedProps.date_fin),
                    e("#edit_heure_deb").val(this.$selectedEvent.extendedProps.heure_deb),
                    // e("#est_lie").val(this.$selectedEvent.extendedProps.est_lie),
                    // e("#event-category").val(this.$selectedEvent.classNames[0]);
                    e('#edit_type_rappel option[value=' + this.$selectedEvent.extendedProps.type_rappel + ']').attr(
                        'selected', 'selected');
                var est_lie = this.$selectedEvent.extendedProps.est_lie == true ? "Oui" : "Non";
                e('#edit_est_lie option[value=' + est_lie + ']').attr('selected', 'selected');

                if (est_lie == "Oui") {
                    let currentContactId = this.$selectedEvent.extendedProps.contact_id;
                    e('#edit_contact_id option[value=' + currentContactId + ']').attr('selected', 'selected');
                    $('.div_edit_contact').show();
                    $('#edit_est_lie').attr('required', 'required');
                } else {
                    $('.div_edit_contact').hide();
                }
                $('#form-edit').attr('action', '/agenda/update/' + this.$selectedEvent.id);


            }),
            (t.prototype.onSelect = function(e) {
                this.$formEvent[0].reset(),
                    this.$formEvent.removeClass("was-validated"),
                    (this.$selectedEvent = null),
                    (this.$newEventData = e),
                    this.$btnDeleteEvent.hide(),
                    this.$modalTitle.text("Add New Event"),
                    this.$modal.show(),
                    this.$calendarObj.unselect();
            }),
            (t.prototype.init = function() {
                var t = new Date(e.now());
                new FullCalendar.Draggable(document.getElementById("external-events"), {
                    itemSelector: ".external-event",
                    eventData: function(t) {
                        return {
                            title: t.innerText,
                            className: e(t).data("class")
                        };
                    },
                });
                var n = Array();
                var val;

                agendas.forEach(function(agenda) {

                    if (agenda.est_terminee == true) {
                        var color = "bg-success";
                    } else {
                        var color = "bg-primary";
                    }

                    var date_fin = new Date(agenda.date_fin);
                    var date_deb = new Date(agenda.date_deb);

                    var jour_deb = date_deb.getDate() < 10 ? '0' + date_deb.getDate() : date_deb.getDate();
                    var mois_deb = date_deb.getMonth() < 10 ? '0' + (date_deb.getMonth() + 1) : date_deb
                        .getMonth() + 1;
                    var annee_deb = date_deb.getFullYear();

                    var jour_fin = date_fin.getDate() < 10 ? '0' + date_fin.getDate() : date_fin.getDate();
                    var mois_fin = date_fin.getMonth() < 10 ? '0' + (date_fin.getMonth() + 1) : date_fin
                        .getMonth() + 1;
                    var annee_fin = date_fin.getFullYear();

                    date_deb = annee_deb + '-' + (mois_deb) + '-' + jour_deb;
                    date_fin = annee_fin + '-' + (mois_fin) + '-' + jour_fin;

                    var title = agenda.est_lie == true ? tab_contacts[agenda.contact_id]["nom"] : agenda
                        .titre;
                    var title = agenda.type_rappel + " - " + title;


                    val = {
                            title: title,
                            titre: agenda.titre,
                            description: agenda.description,
                            start: date_deb,
                            end: date_fin,

                            id: agenda.id,
                            contact_id: agenda.contact_id,
                            date_deb: date_deb,
                            date_fin: date_fin,
                            heure_deb: agenda.heure_deb,
                            heure_fin: agenda.heure_deb,
                            type_rappel: agenda.type_rappel,
                            est_lie: agenda.est_lie,
                            contact: tab_contacts[agenda.contact_id] ? tab_contacts[agenda.contact_id][
                                "contact"
                            ] : "",
                            nom_contact: tab_contacts[agenda.contact_id] ? tab_contacts[agenda.contact_id][
                                "nom"
                            ] : "",
                            est_terminee: agenda.est_terminee,
                            className: color
                        },

                        n.push(val)



                })

                var nx = [],






                    a = this;
                (a.$calendarObj = new FullCalendar.Calendar(a.$calendar[0], {
                    slotDuration: "00:15:00",
                    slotMinTime: "08:00:00",
                    slotMaxTime: "19:00:00",
                    themeSystem: "bootstrap",
                    bootstrapFontAwesome: !1,
                    buttonText: {
                        today: "Aujourd'hui",
                        month: "Mois",
                        week: "Semaine",
                        day: "Jour",
                        list: "Liste",
                        prev: "Préc",
                        next: "Suiv"
                    },
                    locale: "fr",
                    weekText: 'Sem.',
                    weekTextLong: 'Semaine',
                    allDayText: 'Toute la journée',
                    moreLinkText: 'en plus',
                    noEventsText: 'Aucun évènement à afficher',
                    initialView: "dayGridMonth",
                    handleWindowResize: !0,
                    height: e(window).height() - 200,
                    headerToolbar: {
                        left: "prev,next today",
                        center: "title",
                        right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
                    },
                    initialEvents: n,
                    editable: !0,
                    droppable: !0,
                    selectable: !0,
                    dateClick: function(e) {
                        a.onSelect(e);
                    },
                    eventClick: function(e) {
                        a.onEventClick(e);
                    },
                })),
                a.$calendarObj.render(),
                    a.$btnNewEvent.on("click", function(e) {
                        a.onSelect({
                            date: new Date(),
                            allDay: !0
                        });
                    }),
                    a.$formEvent.on("submit", function(t) {
                        t.preventDefault();
                        var n,
                            l = a.$formEvent[0];
                        l.checkValidity() ?
                            (a.$selectedEvent ?
                                (a.$selectedEvent.setProp("title", e("#edit_titre").val()), a.$selectedEvent
                                    .setProp("classNames", [e("#edit_description").val()])) :
                                ((n = {
                                    title: e("#edit_titre").val(),
                                    start: a.$newEventData.date,
                                    allDay: a.$newEventData.allDay,
                                    className: e("#edit_description").val()
                                }), a.$calendarObj.addEvent(n)),
                                a.$modal.hide()) :
                            (t.stopPropagation(), l.classList.add("was-validated"));
                    }),
                    e(
                        a.$btnDeleteEvent.on("click", function(e) {
                            a.$selectedEvent && (a.$selectedEvent.remove(), (a.$selectedEvent = null), a.$modal
                                .hide());
                        })
                    );
            }),
            (e.CalendarApp = new t()),
            (e.CalendarApp.Constructor = t);
        })(window.jQuery),
        (function() {
            "use strict";
            window.jQuery.CalendarApp.init();
        })();
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

        $('#edit_est_lie').change(function(e) {

            if (e.currentTarget.value == "Oui") {
                $('.div_edit_contact').show();
                $('#edit_est_lie').attr('required', 'required');

            } else {
                $('.div_edit_contact').hide();
            }

        });
    </script>
@endsection
