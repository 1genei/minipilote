@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/css/vendor/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .planning-container {
        display: flex;
        gap: 20px;
        padding: 10px;
        height: calc(100vh + 200px);
    }

    .commandes-list {
        flex: 0 0 350px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: flex-basis 0.25s ease;
        display: flex;
        flex-direction: column;
    }
    .commandes-list.collapsed {
        flex: 0 0 36px;
    }
    .commandes-toggle-bar {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding: 5px 6px;
        border-bottom: 1px solid #e3e3e3;
        min-width: 36px;
    }
    .btn-toggle-commandes {
        width: 26px;
        height: 26px;
        border: 1px solid #ccc;
        border-radius: 50%;
        background: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        font-size: 16px;
        line-height: 1;
        color: #555;
        transition: background 0.15s;
    }
    .btn-toggle-commandes:hover { background: #f0f0ff; }
    .commandes-inner {
        flex: 1;
        overflow-y: auto;
        min-height: 0;
    }
    .commandes-list.collapsed .commandes-inner { display: none; }

    .planning-grid {
        flex: 1;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        overflow-x: auto;
    }

    .commande-card {
        padding: 15px;
        margin: 10px;
        background: #f8f9fa;
        border-radius: 6px;
        border-left: 4px solid #727cf5;
    }

    .produit-item {
        margin: 8px 0;
        padding: 8px;
        background: #fff;
        border-radius: 4px;
        border: 1px solid #e3e3e3;
        cursor: move;
        transition: all 0.2s;
    }

    .produit-item:hover {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transform: translateY(-1px);
    }

    .planning-header {
        display: flex;
        padding: 10px;
        border-bottom: 1px solid #e3e3e3;
        position: sticky;
        top: 0;
        background: #fff;
        z-index: 10;
    }

    .time-slot {
        flex: 0 0 120px;
        text-align: center;
        padding: 5px;
        font-weight: 500;
    }

    .planning-body {
        display: flex;
    }

    .time-column {
        flex: 0 0 120px;
        min-height: 400px;
        border-right: 1px solid #e3e3e3;
        position: relative;
    }

    .time-cell {
        height: 40px;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.2s;
    }

    .time-cell:hover {
        background: #f8f9fa;
    }

    .time-cell.droppable {
        background: #e8f0fe;
    }

    .planning-event {
        position: absolute;
        left: 5px;
        right: 5px;
        background: #727cf5;
        color: #fff;
        padding: 5px;
        border-radius: 4px;
        font-size: 12px;
        z-index: 5;
        cursor: pointer;
        transition: all 0.2s;
    }

    .planning-event:hover {
        transform: scale(1.02);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .beneficiaire-tag {
        display: inline-block;
        padding: 2px 8px;
        background: #cfd4ee;
        border-radius: 12px;
        font-size: 12px;
        margin-left: 8px;
    }

    .search-box {
        padding: 15px;
        border-bottom: 1px solid #e3e3e3;
    }

    .commande-numero {
        font-weight: 600;
        color: #6c757d;
        font-size: 14px;
    }

    .empty-message {
        text-align: center;
        padding: 20px;
        color: #6c757d;
    }

    .planning-scroll-x {
        flex: 1 1 0;
        min-width: 0;
        overflow-x: auto;
        overflow-y: auto;
    }
    table.planning-table {
        border-collapse: collapse;
        width: 100%;
        min-width: 1200px;
    }
    .planning-table th, .planning-table td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
    }
    .planning-table th {
        background-color: #f0f0f0;
    }
    .hour-col {
        width: 60px;
        min-width: 60px;
    }
    .minute-col {
        width: 40px;
        min-width: 40px;
    }
    .car-col {
        min-width: 180px;
    }
    .prestation-cell.droppable {
        background: #f8fafd;
        min-width: 120px;
        transition: background 0.2s;
    }
    .prestation-cell.droppable.drag-over {
        background: #e3f2fd;
    }
    .col-tours {
        width: 62px;
        min-width: 62px;
        text-align: center;
        font-size: 11px;
        white-space: nowrap;
    }
    .tours-cell {
        width: 62px;
        min-width: 62px;
        text-align: center;
        padding: 2px;
    }
    .input-tours {
        width: 54px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 3px;
        font-size: 13px;
        padding: 2px 4px;
        background: #fff;
    }
    .input-tours:focus {
        outline: none;
        border-color: #727cf5;
        background: #f0f0ff;
    }
    .produit-item[draggable="true"] {
        cursor: grab;
        background: #fff;
        border: 1.5px solid #727cf5;
        border-radius: 5px;
        margin-bottom: 5px;
        box-shadow: 0 2px 6px rgba(114,124,245,0.08);
        transition: box-shadow 0.2s, background 0.2s;
    }
    .produit-item.dragging {
        opacity: 0.5;
        box-shadow: 0 4px 12px rgba(114,124,245,0.25);
    }
    .col-pd {
        width: 36px;
        min-width: 36px;
        text-align: center;
        font-size: 11px;
        white-space: nowrap;
    }
    .pd-cell {
        width: 36px;
        min-width: 36px;
        text-align: center;
        padding: 2px;
    }
    .input-pd {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    .input-permis  { accent-color: #198754; }
    .input-decharge { accent-color: #dc3545; }
    .col-cam {
        width: 44px;
        min-width: 44px;
        text-align: center;
        font-size: 11px;
        white-space: nowrap;
    }
    .cam-cell {
        width: 44px;
        min-width: 44px;
        text-align: center;
        padding: 2px;
    }
    .input-cam {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #e05c1b;
    }
    .planned-produit {
        background: #e3f0ff;
        border: 2px solid #3d73dd;
        color: #1a237e;
        border-radius: 6px;
        padding: 6px 10px;
        margin: 2px 0;
        font-weight: 500;
        box-shadow: 0 2px 8px rgba(61,115,221,0.10);
    }

    .commande-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 8px;
        padding-top: 8px;
        border-top: 1px solid #e3e3e3;
    }
    .commande-realisee-label {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: #555;
        cursor: pointer;
        user-select: none;
    }
    .input-realisee { accent-color: #198754; cursor: pointer; }
    .commande-card.realisee-card { opacity: 0.6; }
    .commande-card.realisee-card .commande-numero { text-decoration: line-through; }
    .btn-commentaire {
        position: relative;
        background: none;
        border: none;
        cursor: pointer;
        color: #888;
        font-size: 16px;
        padding: 2px 4px;
        border-radius: 4px;
        transition: color 0.15s;
        margin-left: auto;
    }
    .btn-commentaire:hover { color: #727cf5; }
    .dot-commentaire {
        position: absolute;
        top: 1px; right: 1px;
        width: 7px; height: 7px;
        background: #e05c1b;
        border-radius: 50%;
    }
    /* Modal commentaire */
    #modal-commentaire-overlay {
        display: none;
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 9998;
        align-items: center;
        justify-content: center;
    }
    #modal-commentaire-overlay.open { display: flex; }
    #modal-commentaire {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.18);
        padding: 24px;
        width: 420px;
        max-width: 95vw;
    }
    #modal-commentaire h6 { margin: 0 0 12px; font-weight: 600; }
    #modal-commentaire textarea {
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 8px;
        font-size: 13px;
        resize: vertical;
        min-height: 100px;
    }
    #modal-commentaire textarea:focus { outline: none; border-color: #727cf5; }
    .modal-commentaire-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 12px;
    }

    /* Modal prestation */
    #modal-prestation-overlay {
        display: none;
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 9997;
        align-items: center;
        justify-content: center;
    }
    #modal-prestation-overlay.open { display: flex; }
    #modal-prestation {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.18);
        padding: 24px;
        width: 480px;
        max-width: 95vw;
    }
    #modal-prestation h6 { margin: 0 0 16px; font-weight: 700; font-size: 15px; }
    .modal-prest-section { margin-bottom: 14px; }
    .modal-prest-section h6 {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: #888;
        margin-bottom: 6px;
        font-weight: 600;
    }
    .modal-prest-row { display: flex; align-items: center; gap: 8px; font-size: 13px; margin-bottom: 3px; color: #333; }
    .modal-prest-row i { color: #727cf5; width: 16px; text-align: center; }
    .modal-prest-empty { font-size: 12px; color: #aaa; font-style: italic; }
    .modal-prest-footer { display: flex; justify-content: flex-end; gap: 8px; margin-top: 16px; padding-top: 12px; border-top: 1px solid #eee; }

    /* Mode plein écran (F11) */
    body.mp-pleinecran .mp-topbar,
    body.mp-pleinecran .leftside-menu.mp-sidebar,
    body.mp-pleinecran .planning-meta { display: none !important; }

    body.mp-pleinecran .content-page {
        margin-left: 0 !important;
        margin-top: 0 !important;
        padding: 0 !important;
    }
    body.mp-pleinecran .content { padding: 0 !important; }

    body.mp-pleinecran .planning-container {
        height: 100vh !important;
        border-radius: 0;
        padding: 8px;
        margin-bottom: 30px;
    }
    .mp-pleinecran-hint {
        display: none;
        position: fixed;
        bottom: 12px;
        right: 16px;
        background: rgba(0,0,0,0.55);
        color: #fff;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 20px;
        z-index: 9999;
        pointer-events: none;
    }
    body.mp-pleinecran .mp-pleinecran-hint { display: block; }
</style>
@endsection

@section('content')
<div class="content">
    <!-- En-tête de la page -->

    <!-- Infos planning -->
    <div class="row planning-meta">
        <div class="col-12">
            <div class="card">
                <div class="card-body py-2">
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('planning.index') }}" class="btn btn-sm btn-secondary">
                            <i class="mdi mdi-arrow-left me-1"></i> Retour
                        </a>
                        <div class="d-flex gap-4 flex-wrap align-items-center flex-grow-1 ms-2">
                            <h4 class="page-title">
                                {{ $planning->nom }}
                                @if($planning->date)
                                    <small class="text-muted fs-5 ms-1">— {{ \Carbon\Carbon::parse($planning->date)->format('d/m/Y') }}</small>
                                @endif
                                @if($planning->circuit)
                                    <small class="text-muted fs-5 ms-1">— {{ $planning->circuit->nom }}</small>
                                @endif
                            </h4>
                            
                            @if($planning->duree_session)
                                <span><i class="mdi mdi-timer-outline me-1"></i>Créneau : {{ $planning->duree_session }} min</span>
                            @endif
                            @if($planning->nb_creneau_par_session)
                                <span><i class="mdi mdi-format-list-numbered me-1"></i>{{ $planning->nb_creneau_par_session }} créneaux/session</span>
                            @endif
                        
                            @if($planning->statut)
                                <span class="badge bg-info">{{ ucfirst($planning->statut) }}</span>
                            @endif
                        </div>
                        <a href="{{ route('planning.editInfo', Crypt::encrypt($planning->id)) }}" class="btn btn-sm btn-primary">
                            <i class="mdi mdi-pencil me-1"></i> Modifier
                        </a>
                        <a href="{{ route('planning.exportPdf', Crypt::encrypt($planning->id)) }}" class="btn btn-sm btn-danger" target="_blank">
                            <i class="mdi mdi-file-pdf-box me-1"></i> PDF A3
                        </a>
                        <a href="{{ route('planning.exportXls', Crypt::encrypt($planning->id)) }}" class="btn btn-sm btn-success">
                            <i class="mdi mdi-microsoft-excel me-1"></i> XLS
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="planning-container">
        <!-- Liste des commandes -->
        <div class="commandes-list" id="commandes-list">
            <div class="commandes-toggle-bar">
                <button class="btn-toggle-commandes" id="btn-pleinecran" title="Plein écran (F11)" style="margin-right:auto;">
                    <i class="mdi mdi-fullscreen" id="icon-pleinecran"></i>
                </button>
                <button class="btn-toggle-commandes" id="btn-toggle-commandes" title="Réduire">‹</button>
            </div>
            <div class="commandes-inner">
            <div class="search-box">
                <input type="text" class="form-control" placeholder="Rechercher une commande..." id="search-commande">
            </div>

            @forelse($commandes as $commande)
                <div class="commande-card">
                    <div class="commande-numero">
                        Commande N°{{ $commande->numero_commande }}
                        @if($commande->client)
                            <small class="text-muted">
                                - {{ $commande->client->type == 'individu' ?
                                    $commande->client->individu->nom . ' ' . $commande->client->individu->prenom :
                                    $commande->client->entite->raison_sociale }}
                            </small>
                        @endif
                    </div>
                    @php
                        $commandeHasCamera = $commande->produits->contains(
                            fn($p) => str_contains(mb_strtolower($p->nom), 'caméra') || str_contains(mb_strtolower($p->nom), 'camera')
                        );
                    @endphp
                    @foreach($commande->produits as $produit)
                        <div class="produit-item"
                             draggable="true"
                             data-produit-id="{{ $produit->id }}"
                             data-commande-id="{{ $commande->id }}"
                             data-beneficiaire-id="{{ $produit->pivot->beneficiaire_id ?? '' }}"
                             data-has-camera="{{ $commandeHasCamera ? '1' : '0' }}">
                            <div>{{ $produit->nom }}</div>
                            @if($produit->pivot->beneficiaire_id)
                                @php
                                    $beneficiaire = App\Models\Contact::find($produit->pivot->beneficiaire_id);
                                @endphp
                                @if($beneficiaire)
                                    <span class="beneficiaire-tag">
                                        {{ $beneficiaire->type == 'individu' ?
                                            $beneficiaire->individu?->nom . ' ' . $beneficiaire->individu?->prenom :
                                            $beneficiaire->entite?->raison_sociale }}
                                    </span>
                                @endif
                            @endif
                        </div>
                    @endforeach
                    <div class="commande-actions">
                        <label class="commande-realisee-label">
                            <input type="checkbox" class="input-realisee"
                                data-id="{{ Crypt::encrypt($commande->id) }}"
                                {{ $commande->realisee ? 'checked' : '' }}>
                            Réalisée
                        </label>
                        <button class="btn-commentaire"
                            data-id="{{ Crypt::encrypt($commande->id) }}"
                            data-commentaire="{{ e($commande->commentaire_planning ?? '') }}"
                            title="Laisser un commentaire">
                            <i class="mdi mdi-comment-edit-outline"></i>
                            @if($commande->commentaire_planning)
                                <span class="dot-commentaire"></span>
                            @endif
                        </button>
                    </div>
                </div>
            @empty
                <div class="empty-message">
                    <i class="mdi mdi-information-outline me-1"></i>
                    Aucune commande à afficher
                </div>
            @endforelse
            </div>{{-- .commandes-inner --}}
        </div>

        <!-- Grille du planning -->
        @php
            $heureDebut = $planning->heure_debut ? (int) explode(':', $planning->heure_debut)[0] : 9;
            $heureFin   = $planning->heure_fin   ? (int) explode(':', $planning->heure_fin)[0]   : 12;
            $duree      = $planning->duree_session ?? 20;

            $pauseDebut = $planning->a_pause && $planning->heure_debut_pause
                ? substr($planning->heure_debut_pause, 0, 5) : null;
            $pauseFin   = $planning->a_pause && $planning->heure_fin_pause
                ? substr($planning->heure_fin_pause, 0, 5)   : null;

            $slots    = [];
            $wasPause = false;
            for ($hour = $heureDebut; $hour <= $heureFin; $hour++) {
                $minute = 0;
                while ($minute < 60) {
                    $slotTime = sprintf('%02d:%02d', $hour, $minute);
                    $isPause  = $pauseDebut && $pauseFin
                        && $slotTime >= $pauseDebut
                        && $slotTime < $pauseFin;

                    if ($isPause) {
                        $wasPause = true;
                    } else {
                        if ($wasPause) {
                            $slots[]  = ['is_pause' => true, 'label' => 'Pause ' . $pauseDebut . ' – ' . $pauseFin];
                            $wasPause = false;
                        }
                        $slots[] = ['hour' => $hour, 'minute' => sprintf('%02d', $minute), 'is_pause' => false];
                    }
                    $minute += $duree;
                }
            }

            // Voitures du planning, fallback si aucune sélectionnée
            $voitures = $planning->voitures->count()
                ? $planning->voitures
                : collect([]);
        @endphp
        <div class="planning-scroll-x">
            <table class="planning-table">
                <thead>
                    <tr>
                        <th rowspan="2" class="hour-col" style="vertical-align:middle;">Heure</th>
                        <th rowspan="2" class="minute-col" style="vertical-align:middle;">Minute</th>
                        @if($voitures->count())
                            @foreach($voitures as $voiture)
                                <th colspan="7" class="car-col">{{ $voiture->nom }}</th>
                            @endforeach
                        @else
                            <th colspan="7" class="car-col text-muted">Aucune voiture</th>
                        @endif
                    </tr>
                    <tr>
                        @foreach($voitures as $voiture)
                            <th style="width:120px">Instructeur</th>
                            <th>Prestation</th>
                            <th class="col-pd" title="Permis de conduire">P</th>
                            <th class="col-pd" title="Décharge signée">D</th>
                            <th class="col-tours" title="Tours pilotage">Pilotage</th>
                            <th class="col-tours" title="Tours baptême">BP</th>
                            <th class="col-cam" title="Offre caméra">CAM</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php $prevHour = null; @endphp
                    @foreach($slots as $i => $creneau)
                        @if($creneau['is_pause'] ?? false)
                            <tr class="pause-separator-row">
                                <td colspan="{{ 2 + $voitures->count() * 7 }}"
                                    style="background:#fff3cd;color:#856404;font-weight:600;font-size:12px;text-align:center;padding:6px;border:1px solid #ffc107;">
                                    {{ $creneau['label'] }}
                                </td>
                            </tr>
                            @continue
                        @endif
                        <tr>
                            @if($creneau['hour'] !== $prevHour)
                                @php
                                    $count = collect($slots)->where('hour', $creneau['hour'])->count();
                                    $prevHour = $creneau['hour'];
                                @endphp
                                <td rowspan="{{ $count }}" class="hour-col" style="vertical-align:middle;font-weight:bold;font-size:16px;">{{ $creneau['hour'] }}h</td>
                            @endif
                            <td class="minute-col">{{ $creneau['minute'] }}</td>
                            @foreach($voitures as $voiture)
                                @php
                                    $heure = sprintf('%02d:%s', $creneau['hour'], $creneau['minute']);
                                    $key   = $voiture->id . '.' . $heure;
                                    $nbPilotage = $creneaux[$key]->nb_pilotage ?? '';
                                    $nbBp       = $creneaux[$key]->nb_bp ?? '';
                                    $cam        = $creneaux[$key]->cam ?? false;
                                    $permis     = $creneaux[$key]->permis ?? false;
                                    $decharge   = $creneaux[$key]->decharge ?? false;
                                @endphp
                                <td class="instructeur-cell" data-voiture="{{ $voiture->id }}" data-hour="{{ $creneau['hour'] }}" data-minute="{{ $creneau['minute'] }}"></td>
                                <td class="prestation-cell droppable" data-voiture="{{ $voiture->id }}" data-hour="{{ $creneau['hour'] }}" data-minute="{{ $creneau['minute'] }}">
                                    @php $keyP = $voiture->id . '.' . $heure; @endphp
                                    @if(isset($placements[$keyP]))
                                        @foreach($placements[$keyP] as $pl)
                                            @php
                                                $plClient       = $pl->commande->client ?? null;
                                                $plClientInfos  = $plClient ? $plClient->infos() : null;
                                                $plClientNom    = $plClientInfos
                                                    ? ($plClient->type === 'individu'
                                                        ? ($plClientInfos->nom . ' ' . $plClientInfos->prenom)
                                                        : $plClientInfos->raison_sociale)
                                                    : '';
                                                $plClientTel    = $plClientInfos ? ($plClientInfos->telephone_mobile ?: $plClientInfos->telephone_fixe) : '';
                                                $plClientEmail  = $plClientInfos ? $plClientInfos->email : '';
                                                $plBenef        = $pl->beneficiaire;
                                                $plBenefInfos   = $plBenef ? $plBenef->infos() : null;
                                                $plBenefNom     = $plBenefInfos
                                                    ? ($plBenef->type === 'individu'
                                                        ? ($plBenefInfos->nom . ' ' . $plBenefInfos->prenom)
                                                        : $plBenefInfos->raison_sociale)
                                                    : '';
                                                $plBenefTel     = $plBenefInfos ? ($plBenefInfos->telephone_mobile ?: $plBenefInfos->telephone_fixe) : '';
                                                $plBenefEmail   = $plBenefInfos ? $plBenefInfos->email : '';
                                                $memeContact    = $pl->beneficiaire_id
                                                    && $pl->commande->client_prospect_id
                                                    && (int)$pl->beneficiaire_id === (int)$pl->commande->client_prospect_id;
                                            @endphp
                                            <div class="planned-produit"
                                                 data-placement-id="{{ Crypt::encrypt($pl->id) }}"
                                                 data-produit-nom="{{ e($pl->produit->nom) }}"
                                                 data-commande-num="{{ e($pl->commande->numero_commande ?? '') }}"
                                                 data-commande-url="{{ route('commande.show', Crypt::encrypt($pl->commande->id)) }}"
                                                 data-date-commande="{{ $pl->commande->date_commande ? \Carbon\Carbon::parse($pl->commande->date_commande)->format('d/m/Y') : '' }}"
                                                 data-date="{{ $pl->commande->date_realisation_prevue ? \Carbon\Carbon::parse($pl->commande->date_realisation_prevue)->format('d/m/Y') : '' }}"
                                                 data-client-nom="{{ e($plClientNom) }}"
                                                 data-client-tel="{{ e($plClientTel) }}"
                                                 data-client-email="{{ e($plClientEmail) }}"
                                                 data-benef-nom="{{ e($plBenefNom) }}"
                                                 data-benef-tel="{{ e($plBenefTel) }}"
                                                 data-benef-email="{{ e($plBenefEmail) }}"
                                                 data-same-person="{{ $memeContact ? '1' : '0' }}"
                                                 style="cursor:pointer;">
                                                <span>{{ $pl->produit->nom }}</span>
                                                @if($pl->beneficiaire)
                                                    <span class="beneficiaire-tag">{{ $plBenefNom }}</span>
                                                @endif
                                                <button class="btn-supprimer-placement" title="Retirer" style="background:none;border:none;color:#c00;cursor:pointer;float:right;line-height:1;padding:0 2px;">×</button>
                                            </div>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="pd-cell">
                                    <input type="checkbox" class="input-pd input-permis"
                                        data-voiture="{{ $voiture->id }}"
                                        data-heure="{{ $heure }}"
                                        title="Permis de conduire"
                                        {{ $permis ? 'checked' : '' }}>
                                </td>
                                <td class="pd-cell">
                                    <input type="checkbox" class="input-pd input-decharge"
                                        data-voiture="{{ $voiture->id }}"
                                        data-heure="{{ $heure }}"
                                        title="Décharge signée"
                                        {{ $decharge ? 'checked' : '' }}>
                                </td>
                                <td class="tours-cell">
                                    <input type="number" class="input-tours input-pilotage"
                                        min="0" max="99"
                                        data-voiture="{{ $voiture->id }}"
                                        data-heure="{{ $heure }}"
                                        data-champ="nb_pilotage"
                                        value="{{ $nbPilotage }}"
                                        placeholder="—">
                                </td>
                                <td class="tours-cell">
                                    <input type="number" class="input-tours input-bp"
                                        min="0" max="99"
                                        data-voiture="{{ $voiture->id }}"
                                        data-heure="{{ $heure }}"
                                        data-champ="nb_bp"
                                        value="{{ $nbBp }}"
                                        placeholder="—">
                                </td>
                                <td class="cam-cell">
                                    <input type="checkbox" class="input-cam"
                                        data-voiture="{{ $voiture->id }}"
                                        data-heure="{{ $heure }}"
                                        title="Offre caméra"
                                        {{ $cam ? 'checked' : '' }}>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mp-pleinecran-hint">Appuyer sur <strong>Echap</strong> ou <strong>F11</strong> pour quitter le plein écran</div>

<!-- Modal infos prestation -->
<div id="modal-prestation-overlay">
    <div id="modal-prestation">
        <h6 id="mp-titre"></h6>
        <div class="modal-prest-section">
            <h6>Commande</h6>
            <div class="modal-prest-row"><i class="mdi mdi-file-document-outline"></i><span id="mp-commande-num"></span></div>
            <div class="modal-prest-row" id="mp-row-date-commande" style="display:none"><i class="mdi mdi-calendar-plus"></i><span class="text-muted me-1" style="font-size:11px">Commande :</span><span id="mp-date-commande"></span></div>
            <div class="modal-prest-row" id="mp-row-date" style="display:none"><i class="mdi mdi-calendar-check"></i><span class="text-muted me-1" style="font-size:11px">Réalisation :</span><span id="mp-date"></span></div>
        </div>
        <div class="modal-prest-section" id="mp-section-client">
            <h6 id="mp-titre-client">Client</h6>
            <div id="mp-client-body"></div>
        </div>
        <div class="modal-prest-section" id="mp-section-benef">
            <h6>Bénéficiaire</h6>
            <div id="mp-benef-body"></div>
        </div>
        <div class="modal-prest-footer">
            <a id="mp-lien-commande" href="#" class="btn btn-sm btn-primary" target="_blank">
                <i class="mdi mdi-open-in-new me-1"></i>Voir la commande
            </a>
            <button class="btn btn-sm btn-secondary" id="btn-mp-fermer">Fermer</button>
        </div>
    </div>
</div>

<!-- Modal commentaire planning -->
<div id="modal-commentaire-overlay">
    <div id="modal-commentaire">
        <h6><i class="mdi mdi-comment-edit-outline me-1"></i>Commentaire</h6>
        <textarea id="modal-commentaire-texte" placeholder="Saisissez un commentaire…"></textarea>
        <div class="modal-commentaire-actions">
            <button class="btn btn-sm btn-secondary" id="btn-modal-annuler">Annuler</button>
            <button class="btn btn-sm btn-primary" id="btn-modal-sauvegarder">Sauvegarder</button>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('assets/js/planning.js') }}"></script>
<script>
const urlSauvegarderCreneau     = "{{ route('planning.sauvegarderCreneau', Crypt::encrypt($planning->id)) }}";
const urlToggleRealisee         = "{{ route('commande.toggleRealisee', '__ID__') }}";
const urlSauvegarderCommentaire = "{{ route('commande.sauvegarderCommentairePlanning', '__ID__') }}";
const urlSauvegarderPlacement = "{{ route('planning.sauvegarderPlacement', Crypt::encrypt($planning->id)) }}";
const urlSupprimerPlacement   = "{{ route('planning.supprimerPlacement', '__ID__') }}";
const csrfToken = "{{ csrf_token() }}";

let dragged = null;

document.querySelectorAll('.produit-item[draggable="true"]').forEach(item => {
    item.addEventListener('dragstart', function(e) {
        dragged = this;
        this.classList.add('dragging');
    });
    item.addEventListener('dragend', function(e) {
        dragged = null;
        this.classList.remove('dragging');
    });
});

document.querySelectorAll('.prestation-cell.droppable').forEach(cell => {
    cell.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('drag-over');
    });
    cell.addEventListener('dragleave', function(e) {
        this.classList.remove('drag-over');
    });
    cell.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
        if (!dragged) return;

        // Capturer TOUT avant le fetch — dragend nule dragged avant que .then() resolve
        const targetCell     = this;
        const voitureId      = this.dataset.voiture;
        const hour           = this.dataset.hour;
        const minute         = this.dataset.minute;
        const heure          = hour.padStart(2,'0') + ':' + minute.padStart(2,'0');
        const produitId      = dragged.dataset.produitId;
        const commandeId     = dragged.dataset.commandeId;
        const beneficiaireId = dragged.dataset.beneficiaireId || null;
        const draggedHtml    = dragged.innerHTML;
        const hasCamera      = dragged.dataset.hasCamera === '1';

        fetch(urlSauvegarderPlacement, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ voiture_id: voitureId, heure, commande_id: commandeId, produit_id: produitId, beneficiaire_id: beneficiaireId }),
        })
        .then(r => r.json())
        .then(data => {
            if (!data.ok) { console.error('Erreur sauvegarde placement'); return; }

            const div = document.createElement('div');
            div.className = 'planned-produit';
            div.dataset.placementId = data.id_crypte;
            div.innerHTML = draggedHtml
                + '<button class="btn-supprimer-placement" title="Retirer" style="background:none;border:none;color:#c00;cursor:pointer;float:right;line-height:1;padding:0 2px;">×</button>';
            targetCell.appendChild(div);

            if (hasCamera) {
                const row = targetCell.closest('tr');
                const camInput = row ? row.querySelector(`.input-cam[data-voiture="${voitureId}"]`) : null;
                if (camInput && !camInput.checked) {
                    camInput.checked = true;
                    camInput.dispatchEvent(new Event('change'));
                }
            }
        })
        .catch(() => console.error('Erreur réseau placement'));
    });
});

// Suppression d'un placement (délégation depuis le document)
document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-supprimer-placement');
    if (!btn) return;
    const div = btn.closest('.planned-produit');
    if (!div) return;
    const placementId = div.dataset.placementId;
    if (!placementId) { div.remove(); return; }

    const url = urlSupprimerPlacement.replace('__ID__', placementId);
    fetch(url, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrfToken },
    })
    .then(r => r.json())
    .then(data => { if (data.ok) div.remove(); })
    .catch(() => console.error('Erreur suppression placement'));
});

// Bloquer modification par molette sur les inputs nombre
document.querySelectorAll('.input-tours').forEach(function(input) {
    input.addEventListener('wheel', function() { this.blur(); });
});

// Sauvegarde AJAX des colonnes Pilotage et BP au blur
document.querySelectorAll('.input-tours').forEach(function(input) {
    input.addEventListener('change', function() {
        const voitureId = this.dataset.voiture;
        const heure     = this.dataset.heure;
        const champ     = this.dataset.champ;
        const valeur    = this.value === '' ? null : parseInt(this.value, 10);

        const row = this.closest('tr');
        const autreChamp = champ === 'nb_pilotage' ? 'nb_bp' : 'nb_pilotage';
        const autreInput = row.querySelector(`.input-tours[data-voiture="${voitureId}"][data-heure="${heure}"][data-champ="${autreChamp}"]`);
        const autreValeur = autreInput && autreInput.value !== '' ? parseInt(autreInput.value, 10) : null;

        const body = {
            voiture_id: voitureId,
            heure:      heure,
        };
        body[champ] = valeur;
        body[autreChamp] = autreValeur;

        fetch(urlSauvegarderCreneau, {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(body),
        }).then(function(r) {
            if (!r.ok) console.error('Erreur sauvegarde créneau');
        });
    });
});

// Modal infos prestation
(function() {
    var overlay = document.getElementById('modal-prestation-overlay');

    function ligneContact(nom, tel, email) {
        var html = '';
        if (nom)   html += '<div class="modal-prest-row"><i class="mdi mdi-account-outline"></i><span>' + nom + '</span></div>';
        if (tel)   html += '<div class="modal-prest-row"><i class="mdi mdi-phone-outline"></i><a href="tel:' + tel + '">' + tel + '</a></div>';
        if (email) html += '<div class="modal-prest-row"><i class="mdi mdi-email-outline"></i><a href="mailto:' + email + '">' + email + '</a></div>';
        return html || '<span class="modal-prest-empty">Non renseigné</span>';
    }

    document.addEventListener('click', function(e) {
        var div = e.target.closest('.planned-produit');
        if (!div) return;
        if (e.target.closest('.btn-supprimer-placement')) return;

        var d = div.dataset;
        document.getElementById('mp-titre').textContent        = d.produitNom || 'Prestation';
        document.getElementById('mp-commande-num').textContent = 'N° ' + (d.commandeNum || '—');

        var rowDc = document.getElementById('mp-row-date-commande');
        var rowDr = document.getElementById('mp-row-date');
        if (d.dateCommande) { document.getElementById('mp-date-commande').textContent = d.dateCommande; rowDc.style.display = ''; }
        else { rowDc.style.display = 'none'; }
        if (d.date) { document.getElementById('mp-date').textContent = d.date; rowDr.style.display = ''; }
        else { rowDr.style.display = 'none'; }

        document.getElementById('mp-titre-client').textContent = d.samePerson === '1' ? 'Client & Bénéficiaire' : 'Client';
        document.getElementById('mp-client-body').innerHTML    = ligneContact(d.clientNom, d.clientTel, d.clientEmail);
        document.getElementById('mp-benef-body').innerHTML     = ligneContact(d.benefNom, d.benefTel, d.benefEmail);
        var showBenef = d.benefNom && d.samePerson !== '1';
        document.getElementById('mp-section-benef').style.display = showBenef ? '' : 'none';
        document.getElementById('mp-lien-commande').href       = d.commandeUrl || '#';
        overlay.classList.add('open');
    });

    document.getElementById('btn-mp-fermer').addEventListener('click', function() {
        overlay.classList.remove('open');
    });
    overlay.addEventListener('click', function(e) {
        if (e.target === overlay) overlay.classList.remove('open');
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') overlay.classList.remove('open');
    });
})();

// Checkbox "Réalisée"
document.querySelectorAll('.input-realisee').forEach(function(cb) {
    cb.addEventListener('change', function() {
        var card = this.closest('.commande-card');
        var url  = urlToggleRealisee.replace('__ID__', this.dataset.id);
        fetch(url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
        }).then(r => r.json()).then(data => {
            if (data.ok) {
                card.classList.toggle('realisee-card', data.realisee);
            }
        });
    });
    // état initial
    if (cb.checked) cb.closest('.commande-card').classList.add('realisee-card');
});

// Modal commentaire planning
var modalOverlay  = document.getElementById('modal-commentaire-overlay');
var modalTexte    = document.getElementById('modal-commentaire-texte');
var currentCommentaireId = null;
var currentBtnCommentaire = null;

document.querySelectorAll('.btn-commentaire').forEach(function(btn) {
    btn.addEventListener('click', function() {
        currentCommentaireId  = this.dataset.id;
        currentBtnCommentaire = this;
        modalTexte.value = this.dataset.commentaire || '';
        modalOverlay.classList.add('open');
        modalTexte.focus();
    });
});

document.getElementById('btn-modal-annuler').addEventListener('click', function() {
    modalOverlay.classList.remove('open');
});
modalOverlay.addEventListener('click', function(e) {
    if (e.target === modalOverlay) modalOverlay.classList.remove('open');
});

document.getElementById('btn-modal-sauvegarder').addEventListener('click', function() {
    var url  = urlSauvegarderCommentaire.replace('__ID__', currentCommentaireId);
    var texte = modalTexte.value.trim();
    fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ commentaire: texte }),
    }).then(r => r.json()).then(data => {
        if (!data.ok) return;
        if (currentBtnCommentaire) {
            currentBtnCommentaire.dataset.commentaire = texte;
            var dot = currentBtnCommentaire.querySelector('.dot-commentaire');
            if (texte && !dot) {
                var d = document.createElement('span');
                d.className = 'dot-commentaire';
                currentBtnCommentaire.appendChild(d);
            } else if (!texte && dot) {
                dot.remove();
            }
        }
        modalOverlay.classList.remove('open');
    });
});

// Mode plein écran
function togglePleinEcran() {
    var actif = document.body.classList.toggle('mp-pleinecran');
    var icon  = document.getElementById('icon-pleinecran');
    if (icon) {
        icon.className = actif ? 'mdi mdi-fullscreen-exit' : 'mdi mdi-fullscreen';
    }
}
document.getElementById('btn-pleinecran').addEventListener('click', togglePleinEcran);
document.addEventListener('keydown', function(e) {
    if (e.key === 'F11') { e.preventDefault(); togglePleinEcran(); }
    if (e.key === 'Escape' && document.body.classList.contains('mp-pleinecran')) {
        document.body.classList.remove('mp-pleinecran');
        var icon = document.getElementById('icon-pleinecran');
        if (icon) icon.className = 'mdi mdi-fullscreen';
    }
});

// Toggle réduction colonne commandes
(function() {
    var list = document.getElementById('commandes-list');
    var btn  = document.getElementById('btn-toggle-commandes');
    btn.addEventListener('click', function() {
        list.classList.toggle('collapsed');
        btn.textContent = list.classList.contains('collapsed') ? '›' : '‹';
        btn.title       = list.classList.contains('collapsed') ? 'Agrandir' : 'Réduire';
    });
})();

// Sauvegarde AJAX cases P (Permis) et D (Décharge)
['input-permis', 'input-decharge'].forEach(function(cls) {
    var champ = cls === 'input-permis' ? 'permis' : 'decharge';
    document.querySelectorAll('.' + cls).forEach(function(input) {
        input.addEventListener('change', function() {
            var body = { voiture_id: this.dataset.voiture, heure: this.dataset.heure };
            body[champ] = this.checked;
            fetch(urlSauvegarderCreneau, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify(body),
            }).then(function(r) { if (!r.ok) console.error('Erreur sauvegarde ' + champ); });
        });
    });
});

// Sauvegarde AJAX case CAM
document.querySelectorAll('.input-cam').forEach(function(input) {
    input.addEventListener('change', function() {
        fetch(urlSauvegarderCreneau, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({
                voiture_id: this.dataset.voiture,
                heure:      this.dataset.heure,
                cam:        this.checked,
            }),
        }).then(function(r) {
            if (!r.ok) console.error('Erreur sauvegarde CAM');
        });
    });
});
</script>
@endsection
