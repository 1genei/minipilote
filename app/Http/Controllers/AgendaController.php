<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\User;
use App\Models\Contact;
use Auth;
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
    public function listing()
    {
        // Chargement des agendas avec leurs relations
        $agendas = Agenda::with(['user.contact.individu', 'contact.individu', 'contact.entite'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Chargement des contacts non archivés pour les formulaires
        $contacts = Contact::where('archive', false)
            ->with(['individu', 'entite'])
            ->get();

        return view('agenda.listing', compact('agendas', 'contacts'));
    }
    
    
    
      /**
     * Liste des tâches en retard
     * 
     * @return \Illuminate\Http\Response
     */
    public function listing_en_retard()
    {
        // Chargement eager des relations nécessaires
        $agendas = Agenda::where([
            ['est_terminee', false], 
            ['date_deb', '<', date('Y-m-d')]
        ])
        ->with(['user.contact.individu', 'contact.individu', 'contact.entite'])
        ->get();

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
        ->get();

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
