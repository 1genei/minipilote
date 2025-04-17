<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AgendaController extends Controller
{

    /**
     * Agenda général
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $liste_contacts = Contact::with(['individu', 'entite'])->get();
        $tab_contacts = [];
        
        foreach ($liste_contacts as $value) {
            if ($value->type == "individu" && $value->individu) {
                $nom = $value->individu->nom . " " . $value->individu->prenom;
                $contact = $value->individu->telephone_fixe . "/" . $value->individu->telephone_mobile;
            } else if ($value->type == "entite" && $value->entite) {
                $nom = $value->entite->raison_sociale;
                $contact = $value->entite->telephone_fixe . "/" . $value->entite->telephone_mobile;
            } else {
                $nom = "Contact #" . $value->id;
                $contact = "Non renseigné";
            }
            
            $tab_contacts[$value->id] = [
                "nom" => $nom,
                "contact" => $contact
            ];
        }
        $tab_contacts  = json_encode($tab_contacts) ;

        $contacts = Contact::where([['archive',false]])->get();
        
        $agendas = Agenda::with(['user.contact.individu', 'contact.individu', 'contact.entite'])->take(36)->get();
        $agendas = $agendas->toJson();
        
        $agendas = str_replace('\n', '', $agendas);
        //  dd($agendas);

        return view('agenda.index',compact('agendas','contacts','tab_contacts'));
    }
    
    
    /**
     * Agenda général
     * en listing
     * @return \Illuminate\Http\Response
     */
    public function listing(Request $request)
    {
        $query = Agenda::with(['user.contact.individu', 'contact.individu', 'contact.entite']);

        // Récupérer la liste unique des types de rappel existants
        $types_rappel = Agenda::distinct()->pluck('type_rappel')->filter();

        // Filtre par type de rappel
        if ($request->has('type_rappel') && $request->type_rappel != 'all') {
            $query->where('type_rappel', $request->type_rappel);
        }

        // Filtre par priorité
        if ($request->has('priorite') && $request->priorite != 'all') {
            $query->where('priorite', $request->priorite);
        }

        // Tri par date
        $validDirections = ['asc', 'desc'];
        $direction = in_array($request->date_sort, $validDirections) ? $request->date_sort : 'desc';
        
        if ($request->has('date_sort') && in_array($request->date_sort, $validDirections)) {
            $query->orderBy('date_deb', $direction);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Recherche existante
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('type_rappel', 'like', "%{$search}%")
                  ->orWhereHas('contact.individu', function($q) use ($search) {
                      $q->where('nom', 'like', "%{$search}%")
                        ->orWhere('prenom', 'like', "%{$search}%");
                  })
                  ->orWhereHas('contact.entite', function($q) use ($search) {
                      $q->where('raison_sociale', 'like', "%{$search}%");
                  });
            });
        }

        $agendas = $query->paginate(50)->appends($request->query());
        
        // Charger les contacts avec leurs relations
        $contacts = Contact::where('archive', false)
            ->with(['individu', 'entite'])
            ->whereHas('individu', function($query) {
                $query->whereNotNull('nom');
            })
            ->orWhereHas('entite', function($query) {
                $query->whereNotNull('raison_sociale');
            })
            ->get();

        return view('agenda.listing', compact('agendas', 'contacts', 'types_rappel'));
    }
    
    
    
      /**
     * Liste des tâches en retard
     * 
     * @return \Illuminate\Http\Response
     */
    public function listing_en_retard(Request $request)
    {
              
        $query = Agenda::where('date_deb', '<', date('Y-m-d'))
                ->where('est_terminee', false)
                ->orderBy('date_deb', 'asc')
                ->with(['user.contact.individu', 'contact.individu', 'contact.entite']);

        // Récupérer la liste unique des types de rappel existants
        $types_rappel = Agenda::distinct()->pluck('type_rappel')->filter();

        // Filtre par type de rappel
        if ($request->has('type_rappel') && $request->type_rappel != 'all') {
            $query->where('type_rappel', $request->type_rappel);
        }

        // Filtre par priorité
        if ($request->has('priorite') && $request->priorite != 'all') {
            $query->where('priorite', $request->priorite);
        }

        // Tri par date
        $validDirections = ['asc', 'desc'];
        $direction = in_array($request->date_sort, $validDirections) ? $request->date_sort : 'desc';
        
        if ($request->has('date_sort') && in_array($request->date_sort, $validDirections)) {
            $query->orderBy('date_deb', $direction);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Recherche existante
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('type_rappel', 'like', "%{$search}%")
                  ->orWhereHas('contact.individu', function($q) use ($search) {
                      $q->where('nom', 'like', "%{$search}%")
                        ->orWhere('prenom', 'like', "%{$search}%");
                  })
                  ->orWhereHas('contact.entite', function($q) use ($search) {
                      $q->where('raison_sociale', 'like', "%{$search}%");
                  });
            });
        }

        $agendas = $query->paginate(50)->appends($request->query());
        
        // Charger les contacts avec leurs relations
        $contacts = Contact::where('archive', false)
            ->with(['individu', 'entite'])
            ->whereHas('individu', function($query) {
                $query->whereNotNull('nom');
            })
            ->orWhereHas('entite', function($query) {
                $query->whereNotNull('raison_sociale');
            })
            ->get();
            
        return view('agenda.taches_en_retard', compact('agendas', 'types_rappel', 'contacts'));
    }
    
      /**
     * Liste des tâches à faire
     * en listing
     * @return \Illuminate\Http\Response
     */
    public function listing_a_faire(Request $request)
    {
        
        $contacts = Contact::where('archive', false)
            ->with(['individu', 'entite'])
            ->get();

            $query =  Agenda::where([
                ['est_terminee', false], 
                ['date_deb', '>=', date('Y-m-d')]
            ])
            ->with(['user.contact.individu', 'contact.individu', 'contact.entite']);
      
            // Récupérer la liste unique des types de rappel existants
            $types_rappel = Agenda::distinct()->pluck('type_rappel')->filter();
    
            // Filtre par type de rappel
            if ($request->has('type_rappel') && $request->type_rappel != 'all') {
                $query->where('type_rappel', $request->type_rappel);
            }
    
            // Filtre par priorité
            if ($request->has('priorite') && $request->priorite != 'all') {
                $query->where('priorite', $request->priorite);
            }
    
            // Tri par date
            $validDirections = ['asc', 'desc'];
            $direction = in_array($request->date_sort, $validDirections) ? $request->date_sort : 'desc';
            
            if ($request->has('date_sort') && in_array($request->date_sort, $validDirections)) {
                $query->orderBy('date_deb', $direction);
            } else {
                $query->orderBy('created_at', 'desc');
            }
    
            // Recherche existante
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('titre', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('type_rappel', 'like', "%{$search}%")
                      ->orWhereHas('contact.individu', function($q) use ($search) {
                          $q->where('nom', 'like', "%{$search}%")
                            ->orWhere('prenom', 'like', "%{$search}%");
                      })
                      ->orWhereHas('contact.entite', function($q) use ($search) {
                          $q->where('raison_sociale', 'like', "%{$search}%");
                      });
                });
            }
    
            $agendas = $query->paginate(50)->appends($request->query());
            
            // Charger les contacts avec leurs relations
            $contacts = Contact::where('archive', false)
                ->with(['individu', 'entite'])
                ->whereHas('individu', function($query) {
                    $query->whereNotNull('nom');
                })
                ->orWhereHas('entite', function($query) {
                    $query->whereNotNull('raison_sociale');
                })
                ->get();
    
            return view('agenda.taches_a_faire', compact('agendas', 'contacts', 'types_rappel'));
    }
    
    
    
    /**
     *  création d'un agenda
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'titre' => 'required|string|max:255',
                'description' => 'nullable|string',
                'type_rappel' => 'required|string|max:50',
                'date_deb' => 'required|date',
                'date_fin' => 'nullable|date|after_or_equal:date_deb',
                'heure_deb' => 'nullable',
                'heure_fin' => 'nullable',
                'priorite' => 'required|in:basse,moyenne,haute',
                'est_lie' => 'required|in:Oui,Non',
                'contact_id' => 'required_if:est_lie,Oui|nullable|exists:contacts,id',
            ]);

            $agenda = Agenda::create([
                'titre' => $request->titre,
                'user_id' => Auth::id(),
                'type_rappel' => $request->type_rappel,
                'description' => $request->description,
                'date_deb' => $request->date_deb,
                'date_fin' => $request->date_fin,
                'heure_deb' => $request->heure_deb,
                'heure_fin' => $request->heure_fin,
                'priorite' => $request->priorite,
                'est_lie' => $request->est_lie == "Non" ? false : true,
                'contact_id' => $request->est_lie == "Oui" ? $request->contact_id : null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tâche créée avec succès'
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la tâche : ' . $e->getMessage()
            ], 500);
        }
    }
    
    
    
    
    /**
     * Modification d'un agenda
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $agenda_id)
    {
        try {
            $validated = $request->validate([
                'titre' => 'required|string|max:255',
                'description' => 'nullable|string',
                'type_rappel' => 'required|string|max:50',
                'date_deb' => 'required|date',
                'date_fin' => 'nullable|date|after_or_equal:date_deb',
                'heure_deb' => 'nullable',
                'heure_fin' => 'nullable',
                'priorite' => 'required|in:basse,moyenne,haute',
                'est_lie' => 'required|in:Oui,Non',
                'contact_id' => 'required_if:est_lie,Oui|nullable|exists:contacts,id',
                'est_terminee' => 'nullable|boolean'
            ]);

            $agenda = Agenda::findOrFail($agenda_id);
            
            $agenda->update([
                'titre' => $request->titre,
                'type_rappel' => $request->type_rappel,
                'description' => $request->description,
                'date_deb' => $request->date_deb,
                'date_fin' => $request->date_fin,
                'heure_deb' => $request->heure_deb,
                'heure_fin' => $request->heure_fin,
                'priorite' => $request->priorite,
                'est_lie' => $request->est_lie == "Non" ? false : true,
                'contact_id' => $request->est_lie == "Oui" ? $request->contact_id : null,
                'est_terminee' => $request->has('est_terminee') ? true : false
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tâche modifiée avec succès'
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la modification de la tâche : ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * suppression d'un agenda
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($agenda_id)
    {
        //
        $agenda = Agenda::where('id', $agenda_id)->first();
        
        $agenda->delete();
        return "ok";
    }
}
