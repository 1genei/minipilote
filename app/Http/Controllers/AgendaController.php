<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{

    /**
     * Agenda général
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agendas = Agenda::all()->toJson();
           
        $contacts = Contact::where([['archive',false]])->get();
        
        
       $liste_contacts = contact::all();
       
       
       $tab_contacts  = array();

       
       foreach ($liste_contacts as $value) {
       
           $tab_contacts [$value->id]["nom"] = $value->type == "individu" ? $value->infos()?->nom." ".$value->infos()?->prenom :  $value->infos()?->raison_sociale; 
           $tab_contacts [$value->id]["contact"] = $value->infos()?->telephone_fixe . "/".$value->infos()?->telephone_mobile; 
       }
       
       
 
           
       $tab_contacts  = json_encode($tab_contacts) ;
        
        
        
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
        $contacts = Contact::where('archive', false)->with(['individu', 'entite'])->get();

        return view('agenda.listing', compact('agendas', 'contacts', 'types_rappel'));
    }
    
    
    
      /**
     * Liste des tâches en retard
     * 
     * @return \Illuminate\Http\Response
     */
    public function listing_en_retard()
    {
        $agendas = Agenda::where([
            ['est_terminee', false], 
            ['date_deb', '<', date('Y-m-d')]
        ])
        ->with(['user.contact.individu', 'contact.individu', 'contact.entite'])
        ->paginate(50);

        $contacts = Contact::where('archive', false)
            ->with(['individu', 'entite'])
            ->get();

        return view('agenda.taches_en_retard', compact('agendas', 'contacts'));
    }
    
      /**
     * Liste des tâches à faire
     * en listing
     * @return \Illuminate\Http\Response
     */
    public function listing_a_faire()
    {
        $agendas = Agenda::where([
            ['est_terminee', false], 
            ['date_deb', '>=', date('Y-m-d')]
        ])
        ->with(['user.contact.individu', 'contact.individu', 'contact.entite'])
        ->paginate(50);

        $contacts = Contact::where('archive', false)
            ->with(['individu', 'entite'])
            ->get();

        return view('agenda.taches_a_faire', compact('agendas', 'contacts'));
    }
    
    
    
    /**
     *  création d'un agenda
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
    // dd($request->all());
        
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
            'contact_id' => $request->contact_id, 
        
        ]);
        
    return redirect()->back()->with('ok', 'tâche créée');
        
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
        //       

        $agenda = Agenda::where('id',$agenda_id)->first();
        // dd( $request->heure_fin);
        $agenda->titre =  $request->titre; 
        $agenda->type_rappel =  $request->type_rappel; 
        $agenda->description =  $request->description; 
        $agenda->date_deb =  $request->date_deb; 
        $agenda->date_fin =  $request->date_fin; 
        $agenda->heure_deb =  $request->heure_deb; 
        $agenda->heure_fin =  $request->heure_fin; 
        $agenda->priorite =  $request->priorite;
        $agenda->est_lie =  $request->est_lie == "Non" ? false : true ; 
        $agenda->est_terminee =  $request->est_terminee == "Non" ? false : true ; 

      
        if( $request->est_lie == "Oui" && $request->contact_id != "null") $agenda->contact_id =  $request->contact_id; 
        
        
    
        $agenda->update();
    
        
        // dd($request->contact_id2);
        return redirect()->back()->with('ok', 'tâche modifiée ');
        
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
