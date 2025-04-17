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
                                    @can('permission', 'ajouter-agenda')
                                        <button class="btn btn-lg font-16 btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#add-modal"><i class="mdi mdi-plus-circle-outline"></i>
                                            Ajouter tâche
                                        </button>
                                    @endcan
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

                </style>

                <div class="loading-overlay">
                    <div class="loading-content">
                        <div class="spinner-border text-light" role="status"></div>
                        <p class="mt-2">Enregistrement en cours...</p>
                    </div>
                </div>
                {{-- Ajout d'une tâche --}}
                @include('agenda.components.add-modal')
                {{-- Modification d'une tâche --}}
                @include('agenda.components.edit-modal')



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
        var test  = agendas;

        tab_contacts = JSON.parse(tab_contacts.replaceAll('&quot;', '"'));


        !(function(e) {
            "use strict";

            function t() {
                (this.$body = e("body")),
                (this.$modal = new bootstrap.Modal(document.getElementById("modifier-modal"), {
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
                    e("#titre_mod").val(this.$selectedEvent.extendedProps.titre),
                    e("#description_mod").val(this.$selectedEvent.extendedProps.description),
                    e("#date_deb_mod").val(this.$selectedEvent.extendedProps.date_deb),
                    e("#date_fin_mod").val(this.$selectedEvent.extendedProps.date_fin),
                    e("#heure_deb_mod").val(this.$selectedEvent.extendedProps.heure_deb),
                    e("#heure_fin_mod").val(this.$selectedEvent.extendedProps.heure_fin),
                    e("#agenda_id_mod").val(this.$selectedEvent.id),
                    e("#contact_id_mod").val(this.$selectedEvent.extendedProps.contact_id),
                    e("#est_terminee_mod").prop('checked', this.$selectedEvent.extendedProps.est_terminee == true),                   
                    e("#priorite_mod option[value='"+this.$selectedEvent.extendedProps.priorite+"']").attr('selected', 'selected'),

                    e('#type_rappel_mod option[value=' + this.$selectedEvent.extendedProps.type_rappel + ']').attr(
                        'selected', 'selected');
                var est_lie = this.$selectedEvent.extendedProps.est_lie == true ? "Oui" : "Non";
                e('#est_lie_mod option[value=' + est_lie + ']').attr('selected', 'selected');

                if (est_lie == "Oui") {
                    let currentContactId = this.$selectedEvent.extendedProps.contact_id;
                    e('#contact_id_mod option[value=' + currentContactId + ']').attr('selected', 'selected');
                    $('.contact-select-mod').show();
                    $('#edit_est_lie').attr('required', 'required');
                } else {
                    $('.contact-select-mod').hide();
                }
                
                    $('#form-edit').attr('action', '/agendas/update/' + this.$selectedEvent.id);


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
                    height: e(window).height() ,
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
                                (a.$selectedEvent.setProp("title", e("#titre_mod").val()), a.$selectedEvent
                                    .setProp("classNames", [e("#description_mod").val()])) :
                                ((n = {
                                    title: e("#titre_mod").val(),
                                    start: a.$newEventData.date,
                                    allDay: a.$newEventData.allDay,
                                    className: e("#description_mod").val()
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



    

    @stack('scripts')
    @include('partials._sidebar_collapse')
@endsection
