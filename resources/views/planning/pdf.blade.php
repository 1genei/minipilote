<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: DejaVu Sans, Arial, sans-serif;
        font-size: 8.5px;
        color: #1a1a1a;
        background: #fff;
    }

    /* ── Bande décorative top ── */
    .top-bar {
        background: #23b8f1;
        height: 5px;
        width: 100%;
        margin-bottom: 14px;
    }

    /* ── En-tête ── */
    .header-table {
        width: 100%;
        margin-bottom: 14px;
    }
    .header-title {
        font-size: 17px;
        font-weight: bold;
        color: #23b8f1;
        letter-spacing: 0.03em;
    }
    .header-meta {
        margin-top: 5px;
        font-size: 9px;
        color: #555;
    }
    .header-meta span {
        margin-right: 18px;
    }
    .header-meta strong {
        color: #1a1a1a;
    }
    .header-societe {
        text-align: right;
        font-size: 10px;
        font-weight: bold;
        color: #333;
        vertical-align: top;
        padding-top: 4px;
    }
    .header-divider {
        border: none;
        border-top: 1.5px solid #23b8f1;
        margin-bottom: 12px;
    }

    /* ── Tableau planning ── */
    table.planning {
        border-collapse: collapse;
        width: 100%;
    }

    /* En-tête voitures */
    table.planning thead tr.row-voitures th {
        background: #23b8f1;
        color: #fff;
        font-size: 9px;
        font-weight: bold;
        padding: 5px 4px;
        letter-spacing: 0.04em;
        border: 1px solid #1aa8dc;
    }
    table.planning thead tr.row-voitures th.col-heure {
        background: #2c2c2c;
        color: #fff;
    }

    /* Sous-en-têtes colonnes */
    table.planning thead tr.row-cols th {
        background: #f5f5f5;
        color: #555;
        font-size: 7.5px;
        font-weight: bold;
        padding: 3px 2px;
        border: 1px solid #ddd;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Cellules données */
    table.planning tbody td {
        border: 1px solid #e8e8e8;
        padding: 4px 3px;
        vertical-align: middle;
        text-align: center;
    }
    table.planning tbody tr:nth-child(even) td {
        background: #fafafa;
    }
    table.planning tbody tr:nth-child(odd) td {
        background: #fff;
    }

    /* Heure / minute */
    td.cell-heure {
        background: #2c2c2c !important;
        color: #fff;
        font-weight: bold;
        font-size: 11px;
        border-color: #444 !important;
        width: 36px;
    }
    td.cell-minute {
        background: #f0f0f0 !important;
        color: #666;
        font-size: 8px;
        width: 26px;
    }

    /* Prestation */
    td.cell-prestation {
        text-align: left;
        min-width: 90px;
        font-size: 7.5px;
        padding: 3px 5px;
    }
    .prest-nom { font-weight: bold; color: #1a1a1a; }
    .prest-benef { color: #777; font-style: italic; }

    /* Cases à cocher */
    td.cell-check { width: 20px; font-size: 9px; }
    .ico-ok { color: #23b8f1; font-weight: bold; }

    /* Colonnes numériques */
    td.cell-num { width: 30px; font-size: 8px; color: #333; }

    /* Pied de page */
    .footer {
        margin-top: 10px;
        font-size: 7px;
        color: #bbb;
        text-align: right;
        border-top: 1px solid #eee;
        padding-top: 5px;
    }
    .footer-bar {
        background: #23b8f1;
        height: 3px;
        margin-top: 5px;
    }
</style>
</head>
<body>

<div class="top-bar"></div>

<!-- En-tête -->
<table class="header-table">
    <tr>
        <td style="vertical-align:top; width:70%;">
            <div class="header-title">{{ $planning->nom }}</div>
            <div class="header-meta">
                @if($planning->date)
                    <span>Date : <strong>{{ \Carbon\Carbon::parse($planning->date)->format('d/m/Y') }}</strong></span>
                @endif
                @if($planning->circuit)
                    <span>Circuit : <strong>{{ $planning->circuit->nom }}</strong></span>
                @endif
            </div>
        </td>
        @if($societePrincipale)
        <td class="header-societe">
            {{ $societePrincipale->nom ?? $societePrincipale->raison_sociale ?? '' }}
        </td>
        @endif
    </tr>
</table>

<hr class="header-divider">

<!-- Grille -->
<table class="planning">
    <thead>
        <tr class="row-voitures">
            <th class="col-heure" colspan="2" style="width:62px;">Horaire</th>
            @foreach($voitures as $voiture)
                <th colspan="6">{{ $voiture->nom }}</th>
            @endforeach
        </tr>
        <tr class="row-cols">
            <th style="width:36px;">H</th>
            <th style="width:26px;">Min</th>
            @foreach($voitures as $v)
                <th style="min-width:90px;">Prestation</th>
                <th style="width:20px;">P</th>
                <th style="width:20px;">D</th>
                <th style="width:30px;">Pilotage</th>
                <th style="width:30px;">BP</th>
                <th style="width:26px;">CAM</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @php $prevHour = null; @endphp
        @foreach($slots as $slot)
            @if($slot['is_pause'] ?? false)
                <tr>
                    <td colspan="{{ 2 + $voitures->count() * 6 }}"
                        style="background:#fff3cd;color:#856404;font-weight:bold;text-align:center;padding:4px;font-size:8px;border:1px solid #ffc107;">
                        {{ $slot['label'] }}
                    </td>
                </tr>
                @continue
            @endif
            @php
                $heure       = sprintf('%02d:%s', $slot['hour'], $slot['minute']);
                $isNewHour   = $slot['hour'] !== $prevHour;
                $prevHour    = $slot['hour'];
                $countInHour = collect($slots)->where('hour', $slot['hour'])->count();
            @endphp
            <tr>
                @if($isNewHour)
                    <td class="cell-heure" rowspan="{{ $countInHour }}">{{ $slot['hour'] }}h</td>
                @endif
                <td class="cell-minute">{{ $slot['minute'] }}</td>

                @foreach($voitures as $voiture)
                    @php
                        $key     = $voiture->id . '.' . $heure;
                        $creneau = $creneaux[$key] ?? null;
                        $pls     = $placements[$key] ?? collect([]);
                    @endphp
                    <td class="cell-prestation">
                        @foreach($pls as $pl)
                            <div>
                                <span class="prest-nom">{{ $pl->produit->nom }}</span>
                                @if($pl->beneficiaire)
                                    @php
                                        $bi   = $pl->beneficiaire->infos();
                                        $bNom = $pl->beneficiaire->type === 'individu'
                                            ? trim(($bi?->nom ?? '') . ' ' . ($bi?->prenom ?? ''))
                                            : ($bi?->raison_sociale ?? '');
                                    @endphp
                                    @if($bNom)
                                        <span class="prest-benef"> — {{ $bNom }}</span>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                    </td>
                    <td class="cell-check">@if($creneau?->permis)  <span class="ico-ok">✓</span> @endif</td>
                    <td class="cell-check">@if($creneau?->decharge) <span class="ico-ok">✓</span> @endif</td>
                    <td class="cell-num">{{ $creneau?->nb_pilotage ?? '' }}</td>
                    <td class="cell-num">{{ $creneau?->nb_bp       ?? '' }}</td>
                    <td class="cell-check">@if($creneau?->cam) <span class="ico-ok">✓</span> @endif</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">Généré le {{ \Carbon\Carbon::now()->format('d/m/Y à H:i') }}</div>
<div class="footer-bar"></div>

</body>
</html>
