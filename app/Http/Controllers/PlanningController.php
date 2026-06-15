<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Societe;
use App\Models\Circuit;
use App\Models\Evenement;
use App\Models\Planning;
use App\Models\PlanningCreneau;
use App\Models\PlanningPlacement;
use App\Models\User;
use App\Models\Voiture;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;
use OpenSpout\Writer\XLSX\Writer;
use OpenSpout\Writer\XLSX\Options;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Common\Entity\Style\Color;

class PlanningController extends Controller
{
    /*
    * Affichage des plannings
    * @return \Illuminate\Contracts\View\View
    */
    public function index()
    {
        return view('planning.index');
    }

    public function create()
    {
        $evenements = Evenement::where('archive', false)
            ->where(function ($q) {
                $q->whereNull('date_fin')
                  ->orWhere('date_fin', '>=', Carbon::today());
            })
            ->orderBy('date_debut', 'asc')
            ->get();

        $circuits  = Circuit::orderBy('nom')->get();
        $voitures  = Voiture::where('archive', false)->orderBy('nom')->get();
        $modeles   = Planning::where('est_modele', true)->where('statut', 'actif')->get();
        $users     = User::where('archive', false)->with('contact.individu')->orderBy('email')->get();

        $selectedEvenementId = null;
        if (request('evenement_id')) {
            try {
                $selectedEvenementId = Crypt::decrypt(request('evenement_id'));
            } catch (\Exception $e) {
                // ID invalide, on ignore
            }
        }

        return view('planning.create', compact('evenements', 'circuits', 'voitures', 'modeles', 'users', 'selectedEvenementId'));
    }

    public function storePlanning(Request $request)
    {
        $request->validate([
            'nom'                    => 'required|string|max:255',
            'date'                   => 'required|date',
            'heure_debut'            => 'required',
            'heure_fin'              => 'required',
            'duree_session'          => 'required|integer|min:1',
            'nb_creneau_par_session' => 'required|integer|min:1',
            'voitures'               => 'required|array|min:1',
            'instructeurs'           => 'required|array|min:1',
        ], [
            'voitures.required'     => 'Sélectionnez au moins une voiture.',
            'voitures.min'          => 'Sélectionnez au moins une voiture.',
            'instructeurs.required' => 'Sélectionnez au moins un instructeur.',
            'instructeurs.min'      => 'Sélectionnez au moins un instructeur.',
        ]);

        $planning = new Planning();
        $planning->nom              = $request->nom;
        $planning->evenement_id     = $request->evenement_id ?: null;
        $planning->circuit_id       = $request->circuit_id ?: null;
        $planning->date             = $request->date;
        $planning->heure_debut      = $request->heure_debut;
        $planning->heure_fin        = $request->heure_fin;
        $planning->duree_session    = $request->duree_session;
        $planning->nb_creneau_par_session  = $request->nb_creneau_par_session;
        $planning->nb_tour_max_par_session = $request->nb_tour_max_par_session;
        $planning->a_pause          = $request->has('a_pause');
        $planning->heure_debut_pause = $request->heure_debut_pause ?: null;
        $planning->heure_fin_pause  = $request->heure_fin_pause ?: null;
        $planning->statut           = $request->statut ?? 'brouillon';
        $planning->notes            = $request->notes;
        $planning->est_modele       = false;
        $planning->user_id          = Auth::id();
        $planning->save();

        if ($request->filled('voitures')) {
            $planning->voitures()->sync($request->voitures);
        }

        if ($request->filled('instructeurs')) {
            $planning->instructeurs()->sync($request->instructeurs);
        }

        return redirect()->route('planning.edit', Crypt::encrypt($planning->id))
            ->with('ok', 'Planning créé avec succès.');
    }

    public function edit($id)
    {
        $planning = Planning::with(['circuit', 'evenement', 'voitures', 'instructeurs'])->findOrFail(Crypt::decrypt($id));

        $commandes = Commande::with(['produits', 'client'])
            ->where('archive', false)
            ->orderBy('date_realisation_prevue', 'asc')
            ->get();

        // Creneaux indexés par "voiture_id.heure" pour accès rapide en vue
        $creneaux = PlanningCreneau::where('planning_id', $planning->id)
            ->get()
            ->keyBy(fn($c) => $c->voiture_id . '.' . $c->heure);

        // Placements indexés par "voiture_id.heure" (plusieurs par clé)
        $placements = PlanningPlacement::where('planning_id', $planning->id)
            ->with(['produit', 'commande.client.individu', 'commande.client.entite', 'beneficiaire.individu', 'beneficiaire.entite'])
            ->get()
            ->groupBy(fn($p) => $p->voiture_id . '.' . $p->heure);

        return view('planning.edit', compact('planning', 'commandes', 'creneaux', 'placements'));
    }

    public function sauvegarderCreneau(Request $request, $id)
    {
        $planningId = Crypt::decrypt($id);

        $request->validate([
            'voiture_id'   => 'required|integer',
            'heure'        => 'required|string|max:5',
            'nb_pilotage'  => 'nullable|integer|min:0',
            'nb_bp'        => 'nullable|integer|min:0',
            'cam'          => 'nullable|boolean',
            'permis'       => 'nullable|boolean',
            'decharge'     => 'nullable|boolean',
        ]);

        $values = [];
        if ($request->has('nb_pilotage')) { $values['nb_pilotage'] = $request->nb_pilotage; }
        if ($request->has('nb_bp'))       { $values['nb_bp']       = $request->nb_bp; }
        if ($request->has('cam'))         { $values['cam']         = (bool) $request->cam; }
        if ($request->has('permis'))      { $values['permis']      = (bool) $request->permis; }
        if ($request->has('decharge'))    { $values['decharge']    = (bool) $request->decharge; }

        PlanningCreneau::updateOrCreate(
            [
                'planning_id' => $planningId,
                'voiture_id'  => $request->voiture_id,
                'heure'       => $request->heure,
            ],
            $values
        );

        return response()->json(['ok' => true]);
    }

    public function sauvegarderPlacement(Request $request, $id)
    {
        $planningId = Crypt::decrypt($id);

        $request->validate([
            'voiture_id'      => 'required|integer',
            'heure'           => 'required|string|max:5',
            'commande_id'     => 'required|integer',
            'produit_id'      => 'required|integer',
            'beneficiaire_id' => 'nullable|integer',
        ]);

        $placement = PlanningPlacement::create([
            'planning_id'    => $planningId,
            'voiture_id'     => $request->voiture_id,
            'heure'          => $request->heure,
            'commande_id'    => $request->commande_id,
            'produit_id'     => $request->produit_id,
            'beneficiaire_id' => $request->beneficiaire_id ?: null,
        ]);

        return response()->json(['ok' => true, 'id_crypte' => Crypt::encrypt($placement->id)]);
    }

    public function supprimerPlacement(Request $request, $id)
    {
        $placementId = Crypt::decrypt($id);
        PlanningPlacement::findOrFail($placementId)->delete();
        return response()->json(['ok' => true]);
    }

    private function genererSlots(Planning $planning): array
    {
        $heureDebut = $planning->heure_debut ? (int) explode(':', $planning->heure_debut)[0] : 9;
        $heureFin   = $planning->heure_fin   ? (int) explode(':', $planning->heure_fin)[0]   : 12;
        $duree      = $planning->duree_session ?? 20;

        // Normalise HH:MM (retire les secondes éventuelles stockées en DB)
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
        return $slots;
    }

    public function exportPdf($id)
    {
        $planning = Planning::with(['circuit', 'evenement', 'voitures'])->findOrFail(Crypt::decrypt($id));

        $creneaux = PlanningCreneau::where('planning_id', $planning->id)
            ->get()->keyBy(fn($c) => $c->voiture_id . '.' . $c->heure);

        $placements = PlanningPlacement::where('planning_id', $planning->id)
            ->with(['produit', 'beneficiaire.individu', 'beneficiaire.entite'])
            ->get()->groupBy(fn($p) => $p->voiture_id . '.' . $p->heure);

        $slots            = $this->genererSlots($planning);
        $voitures         = $planning->voitures->count() ? $planning->voitures : collect([]);
        $societePrincipale = Societe::where('est_societe_principale', true)->first();

        $pdf = Pdf::loadView('planning.pdf', compact('planning', 'creneaux', 'placements', 'slots', 'voitures', 'societePrincipale'))
            ->setPaper('a3', 'landscape');

        return $pdf->download('planning-' . $planning->id . '.pdf');
    }

    public function exportXls($id)
    {
        $planning = Planning::with(['circuit', 'evenement', 'voitures'])->findOrFail(Crypt::decrypt($id));

        $creneaux = PlanningCreneau::where('planning_id', $planning->id)
            ->get()->keyBy(fn($c) => $c->voiture_id . '.' . $c->heure);

        $placements = PlanningPlacement::where('planning_id', $planning->id)
            ->with(['produit', 'beneficiaire.individu', 'beneficiaire.entite'])
            ->get()->groupBy(fn($p) => $p->voiture_id . '.' . $p->heure);

        $slots    = $this->genererSlots($planning);
        $voitures = $planning->voitures->count() ? $planning->voitures : collect([]);

        // Calcul des largeurs de colonnes selon nombre de voitures
        $options = new Options();
        $options->DEFAULT_ROW_HEIGHT  = 18;
        $options->DEFAULT_COLUMN_WIDTH = 12;

        $writer = new Writer($options);
        $writer->openToBrowser('planning-' . $planning->id . '.xlsx');

        // Largeurs colonnes : Heure=8, Min=6, puis par voiture [Prestation=38, P=5, D=5, Pilotage=9, BP=9, CAM=7]
        $sheet = $writer->getCurrentSheet();
        $sheet->setColumnWidth(8, 1);
        $sheet->setColumnWidth(6, 2);
        $col = 3;
        foreach ($voitures as $v) {
            $sheet->setColumnWidth(38, $col);
            $sheet->setColumnWidth(5,  $col + 1);
            $sheet->setColumnWidth(5,  $col + 2);
            $sheet->setColumnWidth(9,  $col + 3);
            $sheet->setColumnWidth(9,  $col + 4);
            $sheet->setColumnWidth(7,  $col + 5);
            $col += 6;
        }

        $styleBold     = (new Style())->setFontBold();
        $styleVoiture  = (new Style())->setFontBold()->setBackgroundColor('23b8f1')->setFontColor(Color::WHITE);
        $styleHeader   = (new Style())->setFontBold()->setBackgroundColor('ddf1fb');
        $styleInfo     = (new Style())->setFontBold()->setBackgroundColor('f0f8ff');
        $stylePause    = (new Style())->setFontBold()->setBackgroundColor('fff3cd')->setFontColor('856404');

        // Ligne 1 : infos planning
        $date = $planning->date ? Carbon::parse($planning->date)->format('d/m/Y') : '';
        $infoRow = Row::fromValues(
            ['Planning :', $planning->nom, 'Date :', $date, 'Circuit :', $planning->circuit?->nom ?? ''],
            $styleInfo
        );
        $infoRow->setHeight(20);
        $writer->addRow($infoRow);

        // Ligne vide
        $writer->addRow(Row::fromValues([]));

        // Ligne voitures
        $voitureRow = ['', ''];
        foreach ($voitures as $voiture) {
            $voitureRow = array_merge($voitureRow, [$voiture->nom, '', '', '', '', '']);
        }
        $vRow = Row::fromValues($voitureRow, $styleVoiture);
        $vRow->setHeight(22);
        $writer->addRow($vRow);

        // Ligne sous-en-têtes
        $colRow = ['Heure', 'Min'];
        foreach ($voitures as $v) {
            $colRow = array_merge($colRow, ['Prestation', 'P', 'D', 'Pilotage', 'BP', 'CAM']);
        }
        $hRow = Row::fromValues($colRow, $styleHeader);
        $hRow->setHeight(16);
        $writer->addRow($hRow);

        // Lignes de données — tracking pour fusion colonne Heure
        $dataStartRow = 5; // lignes 1-4 = info + vide + voitures + colonnes
        $currentRow   = $dataStartRow;
        $hourGroups   = []; // ['hour' => X, 'start' => N, 'end' => N]

        foreach ($slots as $slot) {
            // Ligne pause
            if ($slot['is_pause'] ?? false) {
                $pRow = Row::fromValues([$slot['label']], $stylePause);
                $pRow->setHeight(16);
                $writer->addRow($pRow);
                $currentRow++;
                continue;
            }

            $heure = sprintf('%02d:%s', $slot['hour'], $slot['minute']);

            // Groupement par heure
            if (empty($hourGroups) || end($hourGroups)['hour'] !== $slot['hour']) {
                $hourGroups[] = ['hour' => $slot['hour'], 'start' => $currentRow, 'end' => $currentRow];
            } else {
                $hourGroups[count($hourGroups) - 1]['end'] = $currentRow;
            }

            $rowData = [$slot['hour'] . 'h', $slot['minute']];
            foreach ($voitures as $voiture) {
                $key      = $voiture->id . '.' . $heure;
                $creneau  = $creneaux[$key] ?? null;
                $pls      = $placements[$key] ?? collect([]);
                $prestation = $pls->map(function ($p) {
                    $benef = $p->beneficiaire;
                    $nom   = $benef ? ($benef->type === 'individu'
                        ? ($benef->individu?->nom . ' ' . $benef->individu?->prenom)
                        : $benef->entite?->raison_sociale) : '';
                    return $p->produit->nom . ($nom ? " ($nom)" : '');
                })->implode(' / ');
                $rowData[] = $prestation;
                $rowData[] = ($creneau?->permis   ? '✓' : '');
                $rowData[] = ($creneau?->decharge  ? '✓' : '');
                $rowData[] = $creneau?->nb_pilotage ?? '';
                $rowData[] = $creneau?->nb_bp       ?? '';
                $rowData[] = ($creneau?->cam ? '✓' : '');
            }
            $dRow = Row::fromValues($rowData);
            $dRow->setHeight(20);
            $writer->addRow($dRow);
            $currentRow++;
        }

        // Fusion colonne Heure (col A = index 0) pour chaque groupe
        foreach ($hourGroups as $group) {
            if ($group['end'] > $group['start']) {
                $options->mergeCells(0, $group['start'], 0, $group['end']);
            }
        }

        $writer->close();
    }

    public function editInfo($id)
    {
        $planning = Planning::with(['circuit', 'evenement', 'voitures', 'instructeurs'])->findOrFail(Crypt::decrypt($id));

        $evenements = Evenement::where('archive', false)
            ->orderBy('date_debut', 'asc')
            ->get();
        $circuits  = Circuit::orderBy('nom')->get();
        $voitures  = Voiture::where('archive', false)->orderBy('nom')->get();
        $users     = User::where('archive', false)->with('contact.individu')->orderBy('email')->get();

        return view('planning.edit-info', compact('planning', 'evenements', 'circuits', 'voitures', 'users'));
    }

    public function updatePlanning(Request $request, $id)
    {
        $planning = Planning::findOrFail(Crypt::decrypt($id));

        $request->validate([
            'nom'                    => 'required|string|max:255',
            'date'                   => 'required|date',
            'heure_debut'            => 'required',
            'heure_fin'              => 'required',
            'duree_session'          => 'required|integer|min:1',
            'nb_creneau_par_session' => 'required|integer|min:1',
            'voitures'               => 'required|array|min:1',
            'instructeurs'           => 'required|array|min:1',
        ], [
            'voitures.required'     => 'Sélectionnez au moins une voiture.',
            'voitures.min'          => 'Sélectionnez au moins une voiture.',
            'instructeurs.required' => 'Sélectionnez au moins un instructeur.',
            'instructeurs.min'      => 'Sélectionnez au moins un instructeur.',
        ]);

        $planning->nom                     = $request->nom;
        $planning->evenement_id            = $request->evenement_id ?: null;
        $planning->circuit_id              = $request->circuit_id ?: null;
        $planning->date                    = $request->date;
        $planning->heure_debut             = $request->heure_debut;
        $planning->heure_fin               = $request->heure_fin;
        $planning->duree_session           = $request->duree_session;
        $planning->nb_creneau_par_session  = $request->nb_creneau_par_session;
        $planning->nb_tour_max_par_session = $request->nb_tour_max_par_session;
        $planning->a_pause                 = $request->has('a_pause');
        $planning->heure_debut_pause       = $request->heure_debut_pause ?: null;
        $planning->heure_fin_pause         = $request->heure_fin_pause ?: null;
        $planning->statut                  = $request->statut ?? 'brouillon';
        $planning->notes                   = $request->notes;
        $planning->save();

        $planning->voitures()->sync($request->voitures ?? []);
        $planning->instructeurs()->sync($request->instructeurs ?? []);

        return redirect()->route('planning.edit', Crypt::encrypt($planning->id))
            ->with('ok', 'Planning modifié avec succès.');
    }

    public function archiverPlanning($id)
    {
        $planning = Planning::findOrFail(Crypt::decrypt($id));
        $planning->est_archive = true;
        $planning->save();

        return redirect()->route('planning.index')
            ->with('ok', 'Le planning a été archivé.');
    }

    public function destroy($id)
    {
        $planning = Planning::findOrFail(Crypt::decrypt($id));
        $planning->delete();

        return response()->json(['ok' => true]);
    }

    public function getEvents(Request $request)
    {
        $date = $request->input('date', Carbon::now()->format('Y-m-d'));
        
        // Pour l'instant, on retourne un tableau vide car on ne sauvegarde pas encore en BD
        return response()->json([
            'status' => 'success',
            'date' => $date,
            'events' => []
        ]);
    }

    /*
    * Affichage des modèles de planning
    * @return \Illuminate\Contracts\View\View
    */
    public function indexModeles()
    {
        $modeles = Planning::where('est_modele', true)
            ->where('statut', 'actif')
            ->with('circuit')
            ->get();
        
        $circuits = Circuit::all();

        return view('parametres.planning.index', compact('modeles', 'circuits'));
    }

    /*
    * Affichage des modèles de planning archivés
    * @return \Illuminate\Contracts\View\View
    */
    public function indexArchives()
    {
        $modeles = Planning::where('est_modele', true)
            ->where('statut', 'archive')
            ->with('circuit')
            ->get();

        return view('parametres.planning.archives', compact('modeles'));
    }
    /*
    * Création d'un modèle de planning
    * @param Request $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'duree_session' => 'required|integer|min:1',
            'nb_creneau_par_session' => 'required|integer|min:1',
            'nb_tour_max_par_session' => 'nullable|integer|min:1',
        ]);

        // Si ce modèle doit être par défaut, on retire ce statut des autres modèles
        if ($request->est_modele_par_defaut) {
            Planning::where('est_modele', true)
                ->where('est_modele_par_defaut', true)
                ->update(['est_modele_par_defaut' => false]);
        }

        $planning = new Planning();
        $planning->circuit_id = $request->circuit_id;
        $planning->nom = $request->nom;
        $planning->user_id = Auth::id();
        $planning->heure_debut = $request->heure_debut;
        $planning->heure_fin = $request->heure_fin;
        $planning->duree_session = $request->duree_session;
        $planning->nb_creneau_par_session = $request->nb_creneau_par_session;
        $planning->nb_tour_max_par_session = $request->nb_tour_max_par_session;
        $planning->a_pause = $request->has('a_pause');
        $planning->heure_debut_pause = $request->heure_debut_pause;
        $planning->heure_fin_pause = $request->heure_fin_pause;
        $planning->notes = $request->notes;
        $planning->est_modele = true;
        $planning->est_modele_par_defaut = $request->has('est_modele_par_defaut');
        $planning->statut = 'actif';
        $planning->save();

        return redirect()->route('parametre.planning.index')
            ->with('ok', 'Le modèle de planning a été créé avec succès.');
    }

    /*
    * Modification d'un modèle de planning
    * @param Request $request
    * @param Planning $planning
    * @return \Illuminate\Http\RedirectResponse
    */
    public function update(Request $request, Planning $planning)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'duree_session' => 'required|integer|min:1',
            'nb_creneau_par_session' => 'required|integer|min:1',
            'nb_tour_max_par_session' => 'nullable|integer|min:1',
        ]);

        // Si ce modèle doit être par défaut, on retire ce statut des autres modèles
        if ($request->est_modele_par_defaut && !$planning->est_modele_par_defaut) {
            Planning::where('est_modele', true)
                ->where('est_modele_par_defaut', true)
                ->update(['est_modele_par_defaut' => false]);
        }

        $planning->circuit_id = $request->circuit_id;
        $planning->nom = $request->nom;
        $planning->heure_debut = $request->heure_debut;
        $planning->heure_fin = $request->heure_fin;
        $planning->duree_session = $request->duree_session;
        $planning->nb_creneau_par_session = $request->nb_creneau_par_session;
        $planning->nb_tour_max_par_session = $request->nb_tour_max_par_session;
        $planning->a_pause = $request->has('a_pause');
        $planning->heure_debut_pause = $request->heure_debut_pause;
        $planning->heure_fin_pause = $request->heure_fin_pause;
        $planning->notes = $request->notes;
        $planning->est_modele_par_defaut = $request->has('est_modele_par_defaut');
        $planning->save();

        return redirect()->route('parametre.planning.index')
            ->with('ok', 'Le modèle de planning a été modifié avec succès.');
    }

    /*
    * Archivage d'un modèle de planning
    * @param Planning $planning
    * @return \Illuminate\Http\RedirectResponse
    */
    public function archiver(Planning $planning)
    {
        $planning->statut = 'archive';
        $planning->save();

        return redirect()->route('parametre.planning.index')
            ->with('ok', 'Le modèle de planning a été archivé avec succès.');
    }

    /*
    * Restauration d'un modèle de planning
    * @param Planning $planning
    * @return \Illuminate\Http\RedirectResponse
    */
    public function restaurer(Planning $planning)
    {
        $planning->statut = 'actif';
        $planning->save();

        return redirect()->route('parametre.planning.archives')
            ->with('ok', 'Le modèle de planning a été restauré avec succès.');
    }
} 