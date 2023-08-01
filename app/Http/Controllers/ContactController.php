<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Individu;
use App\Models\Entite;
use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\EntiteIndividu;

use Illuminate\Support\Facades\Crypt;


class ContactController extends Controller
{
    /**
     * Affiche la liste des contacts
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $contactentites = Contact::where([["type","entite"], ['archive', false]])->get();
        $contactindividus = Contact::where([["type","individu"], ['archive', false]])->get();

        return view('contact.index', compact('contactentites', 'contactindividus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Enregistrer les contacts
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            "email"=>"required|email",
            "nom"=>"required|string"
        ]);
        
        
        $contact = Contact::create([
            "type"=> $request->type,
            "est_prospect"=> $request->prospect ? true : false,
            "est_client"=> $request->client ? true : false,
            "est_fournisseur"=> $request->fournisseur ? true : false,
        ]);
        
        if($request->client ){
            Client::create([
                "contact_id"=> $contact->id,
                "numero"=> $request->numero,            
            ]);
        
        }
        
        if($request->prospect){
            Client::create([
                "contact_id"=> $contact->id,
                "numero"=> $request->numero,            
                "est_prospect"=> true  ,          
                "est_demarrage_prospect"=> true  ,          
                "date_passage_client"=> date("Y-m-d")  ,          
            ]);     
          
        }
        
        if($request->fournisseur){
            Fournisseur::create([
                "contact_id"=> $contact->id,
                "numero"=> $request->numero,            
            ]);
        
        }
        
        if($request->type =="individu"){
            
            Individu::create([
                "email" => $request->email,
                "nom" => $request->nom,
                "prenom" => $request->prenom,
                "contact1" => $request->contact1,
                "contact2" => $request->contact2,
                "adresse" => $request->adresse,
                "code_postal" => $request->code_postal,
                "ville" => $request->ville,
                "contact_id" => $contact->id
            
            ]);
            
        }else{
            Entite::create([
                "type" => $request->type_entite,
                "email" => $request->email,
                "nom" => $request->nom,
                "contact1" => $request->contact1,
                "contact2" => $request->contact2,
                "adresse" => $request->adresse,
                "code_postal" => $request->code_postal,
                "ville" => $request->ville,
                "contact_id" => $contact->id
            
            ]);
        
        }
      
     
        
        if($request->association == null){
            return $contact;
        }else{
            
            return redirect()->back()->with('ok', 'Contact ajouté');
        
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($contact_id)
    {
        $contact = Contact::where('id', Crypt::decrypt($contact_id))->first();
        
    
        if($contact->type == "individu"){
            return view('contact.show_individu', compact('contact'));
            
        }else{
        
    //   dd($contact);
        
            $individus_existants = EntiteIndividu::where([['entite_id', $contact->entite->id]])->get();
            $ids_existant = array();
           
          
            foreach ($individus_existants as $ind) {
                array_push($ids_existant, $ind->individu->contact->id); 
            }
            
            $newcontacts = Contact::where([['archive', false], ['type', 'individu']])->whereNotIn('id', $ids_existant)->get();

            return view('contact.show_entite', compact('contact', 'newcontacts'));
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $contact_id)
    {
        $request->validate([
            "email"=>"required|email",
            "nom"=>"required|string"
        ]);
  
        $contact = Contact::where('id', $contact_id)->first();
        // $client = $contact->client;
        // $fournisseur = $contact->fournisseur;
        $individu = $contact->individu;
        $entite = $contact->entite;
  
//   dd($fournisseur);
  
        $contact->type = $request->type;

   
        $contact->update();
        
        if($request->type =="individu"){
            
            $individu->email = $request->email;
            $individu->nom = $request->nom;
            $individu->prenom = $request->prenom;
            $individu->contact1 = $request->contact1;
            $individu->contact2 = $request->contact2;
            $individu->adresse = $request->adresse;
            $individu->code_postal = $request->code_postal;
            $individu->ville = $request->ville;
            $individu->contact_id = $contact->id;
            
            $individu->update();
            
        }else{
         
            $entite->type = $request->type_entite;
            $entite->email = $request->email;
            $entite->nom = $request->nom;
            $entite->contact1 = $request->contact1;
            $entite->contact2 = $request->contact2;
            $entite->adresse = $request->adresse;
            $entite->code_postal = $request->code_postal;
            $entite->ville = $request->ville;
            $entite->contact_id = $contact->id;
            
            $entite->update();
        }
        
        
        return redirect()->back()->with('ok', 'Contact modifié');
    }


    /**
     * Associer des individu à une entité
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function associer_individu(Request $request, $entite_id)
    {
        $entite = Entite::where('id',$entite_id)->first();
        
      
        
        if($request->contact_existant){

            $entite->individus()->syncWithoutDetaching($request->newcontacts);
            
        }else{
            
            $contact = $this->store($request);
        
            $entite->individus()->syncWithoutDetaching($contact->individu->id);
        }
        
        
        return redirect()->back()->with('ok', 'Individu associé');

        
    }
    
    
    /**
     * Associer des individu à une entité
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deassocier_individu($entite_id, $individu_id)
    {
        $entite = Entite::where('id', $entite_id)->first();
        
        $entite->individus()->detach($individu_id);
        
        return redirect()->back()->with('ok', 'Individu supprimé de la liste');

        
    }
    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
     /**
     * Archiver un contact
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archiver($contact_id)
    {
        $contact = Contact::where('id', Crypt::decrypt($contact_id))->first();
        
        
        $contact->archive = true;
        $contact->update();
        
        return "200";
    }
}
