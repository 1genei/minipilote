@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="content">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('parametre.index') }}">Paramètres</a></li>
                        <li class="breadcrumb-item active">Modèles de planning</li>
                    </ol>
                </div>
                <h4 class="page-title">Modèles de planning</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Alert -->
    <div class="row">
        <div class="col-12">
            @if (session('ok'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('ok') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>
    @include('layouts.nav_parametre')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#add-model-modal">
                                <i class="mdi mdi-plus-circle me-2"></i> Ajouter un modèle de planning
                            </button>
                        </div>
                        <div class="col-sm-7">
                            <div class="text-sm-end">
                                <a href="{{ route('parametre.planning.archives') }}" class="btn btn-light mb-2">
                                    <i class="mdi mdi-archive me-1"></i> Voir les archives
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered w-100 dt-responsive nowrap" id="modeles-datatable">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Circuit</th>
                                    <th>Horaires</th>
                                    <th>Sessions</th>
                                    <th>Pause</th>
                                    <th>Statut</th>
                                    <th>Par défaut</th>
                                    <th style="width: 85px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modeles as $modele)
                                <tr>
                                    <td>{{ $modele->nom }}</td>
                                    <td>{{ $modele->circuit?->nom }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($modele->heure_debut)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($modele->heure_fin)->format('H:i') }}
                                    </td>
                                    <td>
                                        {{ $modele->duree_session }}min 
                                        ({{ $modele->nb_creneau_par_session }} créneaux)
                                        @if($modele->nb_tour_max_par_session)
                                            <br>Max {{ $modele->nb_tour_max_par_session }} tours
                                        @endif
                                    </td>
                                    <td>
                                        @if($modele->a_pause)
                                            {{ \Carbon\Carbon::parse($modele->heure_debut_pause)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($modele->heure_fin_pause)->format('H:i') }}
                                        @else
                                            Non
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $modele->statut == 'actif' ? 'success' : 'danger' }}">
                                            {{ $modele->statut }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($modele->est_modele_par_defaut)
                                            <i class="mdi mdi-check-circle text-success"></i>
                                        @endif
                                    </td>
                                    <td class="table-action">
                                        <button type="button" class="btn btn-primary btn-sm edit-model" 
                                                data-bs-toggle="modal" data-bs-target="#edit-model-modal"
                                                data-model="{{ json_encode($modele) }}">
                                            <i class="mdi mdi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm delete-model"
                                                data-model-id="{{ $modele->id }}">
                                            <i class="mdi mdi-archive"></i>
                                        </button>
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

<!-- Add Model Modal -->
<div class="modal fade" id="add-model-modal" tabindex="-1" aria-labelledby="add-model-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('parametre.planning.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="add-model-modal-label">Ajouter un modèle de planning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nom" class="form-label">Nom du modèle</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="circuit_id" class="form-label">Circuit</label>
                            <select class="form-select" id="circuit_id" name="circuit_id">
                                <option value="">Sélectionner un circuit</option>
                                @foreach($circuits as $circuit)
                                    <option value="{{ $circuit->id }}">{{ $circuit->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="heure_debut" class="form-label">Heure de début</label>
                            <input type="time" class="form-control" id="heure_debut" name="heure_debut" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="heure_fin" class="form-label">Heure de fin</label>
                            <input type="time" class="form-control" id="heure_fin" name="heure_fin" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="duree_session" class="form-label">Durée d'une session (minutes)</label>
                            <input type="number" class="form-control" id="duree_session" name="duree_session" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nb_tour_max_par_session" class="form-label">Nombre de tours maximum par session</label>
                            <input type="number" class="form-control" id="nb_tour_max_par_session" name="nb_tour_max_par_session" min="1">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nb_creneau_par_session" class="form-label">Nombre de créneaux par session</label>
                            <input type="number" class="form-control" id="nb_creneau_par_session" name="nb_creneau_par_session" required>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="a_pause" name="a_pause">
                                <label class="form-check-label" for="a_pause">Inclure une pause</label>
                            </div>
                        </div>
                    </div>

                    <div class="pause-times" style="display: none;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="heure_debut_pause" class="form-label">Début de la pause</label>
                                <input type="time" class="form-control" id="heure_debut_pause" name="heure_debut_pause">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="heure_fin_pause" class="form-label">Fin de la pause</label>
                                <input type="time" class="form-control" id="heure_fin_pause" name="heure_fin_pause">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="est_modele_par_defaut" name="est_modele_par_defaut">
                                <label class="form-check-label" for="est_modele_par_defaut">Définir comme modèle par défaut</label>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="est_modele" value="1">
                    <input type="hidden" name="statut" value="actif">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Model Modal -->
<div class="modal fade" id="edit-model-modal" tabindex="-1" aria-labelledby="edit-model-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="edit-model-form" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-model-modal-label">Modifier le modèle de planning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_nom" class="form-label">Nom du modèle</label>
                            <input type="text" class="form-control" id="edit_nom" name="nom" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_circuit_id" class="form-label">Circuit</label>
                            <select class="form-select" id="edit_circuit_id" name="circuit_id">
                                <option value="">Sélectionner un circuit</option>
                                @foreach($circuits as $circuit)
                                    <option value="{{ $circuit->id }}">{{ $circuit->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_heure_debut" class="form-label">Heure de début</label>
                            <input type="time" class="form-control" id="edit_heure_debut" name="heure_debut" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_heure_fin" class="form-label">Heure de fin</label>
                            <input type="time" class="form-control" id="edit_heure_fin" name="heure_fin" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_duree_session" class="form-label">Durée d'une session (minutes)</label>
                            <input type="number" class="form-control" id="edit_duree_session" name="duree_session" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_nb_tour_max_par_session" class="form-label">Nombre de tours maximum par session</label>
                            <input type="number" class="form-control" id="edit_nb_tour_max_par_session" name="nb_tour_max_par_session" min="1">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_nb_creneau_par_session" class="form-label">Nombre de créneaux par session</label>
                            <input type="number" class="form-control" id="edit_nb_creneau_par_session" name="nb_creneau_par_session" required>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="edit_a_pause" name="a_pause">
                                <label class="form-check-label" for="edit_a_pause">Inclure une pause</label>
                            </div>
                        </div>
                    </div>

                    <div class="edit-pause-times" style="display: none;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_heure_debut_pause" class="form-label">Début de la pause</label>
                                <input type="time" class="form-control" id="edit_heure_debut_pause" name="heure_debut_pause">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_heure_fin_pause" class="form-label">Fin de la pause</label>
                                <input type="time" class="form-control" id="edit_heure_fin_pause" name="heure_fin_pause">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="edit_notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="edit_notes" name="notes" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="edit_est_modele_par_defaut" name="est_modele_par_defaut">
                                <label class="form-check-label" for="edit_est_modele_par_defaut">Définir comme modèle par défaut</label>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="est_modele" value="1">
                    <input type="hidden" name="statut" value="actif">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>

<script>
$(document).ready(function() {
    // Initialisation de la DataTable
    $('#modeles-datatable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
        }
    });

    // Gestion de l'affichage des champs de pause dans le formulaire d'ajout
    $('#a_pause').change(function() {
        $('.pause-times').toggle(this.checked);
    });

    // Gestion de l'affichage des champs de pause dans le formulaire d'édition
    $('#edit_a_pause').change(function() {
        $('.edit-pause-times').toggle(this.checked);
    });

    // Gestion de l'édition
    $('.edit-model').click(function() {
        const model = $(this).data('model');
        const form = $('#edit-model-form');
        form.attr('action', `/parametres/planning/${model.id}`);
        
        // Remplir les champs avec les données du modèle
        $('#edit-model-modal #edit_nom').val(model.nom);
        $('#edit-model-modal #edit_circuit_id').val(model.circuit_id);
        $('#edit-model-modal #edit_heure_debut').val(model.heure_debut);
        $('#edit-model-modal #edit_heure_fin').val(model.heure_fin);
        $('#edit-model-modal #edit_duree_session').val(model.duree_session);
        $('#edit-model-modal #edit_nb_tour_max_par_session').val(model.nb_tour_max_par_session);
        $('#edit-model-modal #edit_nb_creneau_par_session').val(model.nb_creneau_par_session);
        $('#edit-model-modal #edit_a_pause').prop('checked', model.a_pause);
        $('#edit-model-modal #edit_heure_debut_pause').val(model.heure_debut_pause);
        $('#edit-model-modal #edit_heure_fin_pause').val(model.heure_fin_pause);
        $('#edit-model-modal #edit_notes').val(model.notes);
        $('#edit-model-modal #edit_est_modele_par_defaut').prop('checked', model.est_modele_par_defaut);
        
        // Afficher/masquer les champs de pause
        $('#edit-model-modal .edit-pause-times').toggle(model.a_pause);
    });

    // Gestion de l'archivage
    $('.delete-model').click(function() {
        const modelId = $(this).data('model-id');
        
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Voulez-vous archiver ce modèle de planning ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, archiver',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/parametres/planning/${modelId}/archiver`;
            }
        });
    });
});
</script>
@endsection 