<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Circuit;
use App\Models\Planning;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PlanningController extends Controller
{
    /*
    * Affichage des plannings
    * @return \Illuminate\Contracts\View\View
    */
    public function index()
    {
        // Récupérer les commandes non archivées avec leurs produits et la relation pivot
        $commandes = Commande::with(['produits', 'client'])
            ->where('archive', false)
            // ->whereDate('date_realisation_prevue', '>=', Carbon::now()->startOfDay())
            ->orderBy('date_realisation_prevue', 'asc')
            ->get();
        return view('planning.index', compact('commandes'));
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