@extends('layouts.app')

@section('title', 'Modifier le planning')

@section('content')
<div class="content">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('planning.index') }}">Plannings</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('planning.edit', Crypt::encrypt($planning->id)) }}">{{ $planning->nom }}</a></li>
                        <li class="breadcrumb-item active">Modifier</li>
                    </ol>
                </div>
                <h4 class="page-title">Modifier le planning</h4>
            </div>
        </div>
    </div>

    <form action="{{ route('planning.updatePlanning', Crypt::encrypt($planning->id)) }}" method="POST" id="form-planning">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">

            {{-- Colonne gauche --}}
            <div class="col-lg-8">

                {{-- Informations générales --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="mdi mdi-calendar me-2"></i>Informations générales</h5>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="nom" class="form-label">Nom du planning <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                       id="nom" name="nom" value="{{ old('nom', $planning->nom) }}" required>
                                @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="statut" class="form-label">Statut</label>
                                <select class="form-select" id="statut" name="statut">
                                    <option value="actif"     {{ old('statut', $planning->statut) == 'actif'     ? 'selected' : '' }}>Actif</option>
                                    <option value="brouillon" {{ old('statut', $planning->statut) == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="evenement_id" class="form-label">Événement</label>
                                <select class="form-select" id="evenement_id" name="evenement_id">
                                    <option value="">— Aucun événement —</option>
                                    @foreach($evenements as $ev)
                                        <option value="{{ $ev->id }}"
                                            data-circuit="{{ $ev->circuit_id }}"
                                            data-date="{{ $ev->date_debut }}"
                                            {{ old('evenement_id', $planning->evenement_id) == $ev->id ? 'selected' : '' }}>
                                            {{ $ev->nom }}
                                            @if($ev->date_debut)
                                                — {{ \Carbon\Carbon::parse($ev->date_debut)->format('d/m/Y') }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="date" class="form-label">Date du planning <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                       id="date" name="date" value="{{ old('date', $planning->date) }}" required>
                                @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="circuit_id" class="form-label">Circuit</label>
                                <select class="form-select" id="circuit_id" name="circuit_id">
                                    <option value="">— Aucun circuit —</option>
                                    @foreach($circuits as $circuit)
                                        <option value="{{ $circuit->id }}"
                                            {{ old('circuit_id', $planning->circuit_id) == $circuit->id ? 'selected' : '' }}>
                                            {{ $circuit->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes', $planning->notes) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Configuration des sessions --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="mdi mdi-timer-outline me-2"></i>Configuration des sessions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="heure_debut" class="form-label">Heure de début <span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('heure_debut') is-invalid @enderror"
                                       id="heure_debut" name="heure_debut"
                                       value="{{ old('heure_debut', $planning->heure_debut) }}" required>
                                @error('heure_debut') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="heure_fin" class="form-label">Heure de fin <span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('heure_fin') is-invalid @enderror"
                                       id="heure_fin" name="heure_fin"
                                       value="{{ old('heure_fin', $planning->heure_fin) }}" required>
                                @error('heure_fin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="duree_session" class="form-label">Durée session (min) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('duree_session') is-invalid @enderror"
                                       id="duree_session" name="duree_session"
                                       min="1" value="{{ old('duree_session', $planning->duree_session) }}" required>
                                @error('duree_session') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="nb_creneau_par_session" class="form-label">Créneaux/session <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('nb_creneau_par_session') is-invalid @enderror"
                                       id="nb_creneau_par_session" name="nb_creneau_par_session"
                                       min="1" value="{{ old('nb_creneau_par_session', $planning->nb_creneau_par_session) }}" required>
                                @error('nb_creneau_par_session') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="nb_tour_max_par_session" class="form-label">Tours max/session</label>
                                <input type="number" class="form-control"
                                       id="nb_tour_max_par_session" name="nb_tour_max_par_session"
                                       min="1" value="{{ old('nb_tour_max_par_session', $planning->nb_tour_max_par_session) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="a_pause" name="a_pause"
                                       {{ old('a_pause', $planning->a_pause) ? 'checked' : '' }}>
                                <label class="form-check-label" for="a_pause">Inclure une pause</label>
                            </div>
                        </div>

                        <div id="pause-fields" style="{{ old('a_pause', $planning->a_pause) ? '' : 'display:none;' }}">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="heure_debut_pause" class="form-label">Début de la pause</label>
                                    <input type="time" class="form-control" id="heure_debut_pause"
                                           name="heure_debut_pause" value="{{ old('heure_debut_pause', $planning->heure_debut_pause) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="heure_fin_pause" class="form-label">Fin de la pause</label>
                                    <input type="time" class="form-control" id="heure_fin_pause"
                                           name="heure_fin_pause" value="{{ old('heure_fin_pause', $planning->heure_fin_pause) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Colonne droite --}}
            <div class="col-lg-4">

                {{-- Voitures --}}
                <div class="card @error('voitures') border-danger @enderror">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="mdi mdi-car me-2"></i>Voitures <span class="text-danger">*</span></h5>
                    </div>
                    <div class="card-body" style="max-height:260px;overflow-y:auto;">
                        @forelse($voitures as $voiture)
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox"
                                       name="voitures[]" id="voiture_{{ $voiture->id }}"
                                       value="{{ $voiture->id }}"
                                       {{ in_array($voiture->id, old('voitures', $planning->voitures->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <label class="form-check-label" for="voiture_{{ $voiture->id }}">
                                    {{ $voiture->nom }}
                                </label>
                            </div>
                        @empty
                            <p class="text-muted small">Aucune voiture disponible.</p>
                        @endforelse
                    </div>
                    @error('voitures')
                        <div class="card-footer py-1 text-danger small"><i class="mdi mdi-alert-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                {{-- Instructeurs --}}
                <div class="card @error('instructeurs') border-danger @enderror">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="mdi mdi-account-multiple me-2"></i>Instructeurs <span class="text-danger">*</span></h5>
                    </div>
                    <div class="card-body" style="max-height:260px;overflow-y:auto;">
                        @forelse($users as $user)
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox"
                                       name="instructeurs[]" id="instructeur_{{ $user->id }}"
                                       value="{{ $user->id }}"
                                       {{ in_array($user->id, old('instructeurs', $planning->instructeurs->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <label class="form-check-label" for="instructeur_{{ $user->id }}">
                                    @php
                                        $infos = $user->contact?->individu;
                                        echo $infos ? e(trim($infos->nom . ' ' . $infos->prenom)) : e($user->email);
                                    @endphp
                                </label>
                            </div>
                        @empty
                            <p class="text-muted small">Aucun utilisateur disponible.</p>
                        @endforelse
                    </div>
                    @error('instructeurs')
                        <div class="card-footer py-1 text-danger small"><i class="mdi mdi-alert-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                {{-- Boutons --}}
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="mdi mdi-check me-1"></i> Enregistrer les modifications
                    </button>
                    <a href="{{ route('planning.edit', Crypt::encrypt($planning->id)) }}" class="btn btn-light">
                        <i class="mdi mdi-arrow-left me-1"></i> Annuler
                    </a>
                </div>

            </div>
        </div>
    </form>

</div>
@endsection

@section('script')
<script>
$(document).ready(function () {

    // Sélection événement → circuit + date
    $('#evenement_id').on('change', function () {
        var option  = $(this).find(':selected');
        var circuit = option.data('circuit');
        var date    = option.data('date');
        if (circuit) $('#circuit_id').val(circuit);
        if (date)    $('#date').val(date);
    });

    // Toggle champs pause
    $('#a_pause').on('change', function () {
        $('#pause-fields').toggle(this.checked);
    });

    // Validation voitures + instructeurs obligatoires
    $('#form-planning').on('submit', function(e) {
        const erreurs = [];
        if ($('input[name="voitures[]"]:checked').length === 0) {
            erreurs.push('Sélectionnez au moins une voiture.');
        }
        if ($('input[name="instructeurs[]"]:checked').length === 0) {
            erreurs.push('Sélectionnez au moins un instructeur.');
        }
        if (erreurs.length > 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Champs requis',
                html: erreurs.join('<br>'),
            });
        }
    });

});
</script>
@endsection
