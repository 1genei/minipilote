<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Contact;
use App\Models\Individu;
use App\Models\Entite;
use App\Models\Client;
use App\Models\Fournisseur;

class ProspectController extends Controller
{
    /**
     * Affiche la liste des contacts
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $contactentites = Contact::where([["type","entite"], ['est_prospect', true], ['archive', false]])->get();
        $contactindividus = Contact::where([["type","individu"], ['est_prospect', true], ['archive', false]])->get();

        return view('prospect.index', compact('contactentites', 'contactindividus'));
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
            "est_prospect"=> true,
           
        ]);
    
        Client::create([
            "contact_id"=> $contact->id,
            "numero"=> $request->numero,            
            "est_prospect"=> true  ,          
            "est_demarrage_prospect"=> true  ,          
            "date_passage_client"=> date("Y-m-d")  ,          
        ]);     
                  
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
        
        
        return redirect()->back()->with('ok', 'Prospect ajouté');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        $individu = $contact->individu;
        $entite = $contact->entite;

  
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
        
        
        return redirect()->back()->with('ok', 'Prospect modifié');
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
}
