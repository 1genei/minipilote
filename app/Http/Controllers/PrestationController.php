<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestation;
use App\Models\Contact;
use App\Models\Individu;
use App\Models\Typecontact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PrestationController extends Controller
{

    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        $prestations = Prestation::all();
        return view('prestation.index', compact('prestations'));
    }
    
    /**
    * enregistrer une prestation
    */
    public function store(Request $request)
    {
    
        $request->validate([
            'numero' => 'required|integer|unique:prestations',
            'client_id' => 'required|integer',
        ]);
        
 
        $type_contact = "individu";
  

    
        if(!$request->contact_existant){
            $contact = Contact::create([
                "user_id" => Auth::user()->id,
                "type" => $type_contact,
                "nature" => $request->nature,
            ]);
        }else{
            $contact = Contact::where('id', $request->newcontact)->first();
        }
       
        
        $typecontact = Typecontact::where('type', $request->typecontact)->first();
        $contact->typeContacts()->attach($typecontact->id);

        
        $beneficiaire = Individu::create([
            "email" => $request->email,
            "contact_id" => $contact->id,
            "nom" => $request->nom,
            "prenom" => $request->prenom,
          
            "numero_voie" => $request->numero_voie,
            "nom_voie" => $request->nom_voie,
            "complement_voie" => $request->complement_voie,
            "code_postal" => $request->code_postal,
            "ville" => $request->ville,
            "pays" => $request->pays,

            "civilite" => $request->civilite,
           
            "indicatif_fixe" => $request->indicatif_fixe,
            "telephone_fixe" => $request->telephone_fixe,
            "indicatif_mobile" => $request->indicatif_mobile,
            "telephone_mobile" => $request->telephone_mobile,

            "notes" => $request->notes,

        ]);
        
               
        $prestation = new Prestation();
        $prestation->numero = $request->numero;
        $prestation->nom = $request->nom_prestation;
        $prestation->client_id = $request->client_id;
        $prestation->beneficiaire_id = $contact->id ;
        // $prestation->client_est_beneficiaire = $request->client_est_beneficiaire;
        $prestation->user_id = Auth::user()->id;
        $prestation->date_prestation = $request->date_prestation;
        $prestation->methode_paiement = $request->methode_paiement;
        $prestation->montant_ttc = $request->montant_ttc;
        $prestation->save();
        
        return redirect()->back()->with('ok', 'Prestation enregistrée avec succès');
    }
    
    
    /**
    * edit the specified resource.
    */
    public function edit($prestation_id){
    
        $prestation = Prestation::where('id', Crypt::decrypt($prestation_id))->first();
        $newcontacts = Contact::where([['archive', false], ['type', 'individu']])->get();

        
        return view('prestation.edit', compact('prestation','newcontacts'));
    
    }
    
    /**
    * update the specified resource.
    */
    public function update(Request $request, $prestation_id){
    
        $prestation = Prestation::where('id', Crypt::decrypt($prestation_id))->first();
        
        $request->validate([
            'numero' => 'required|integer',
        ]);
        
        $prestation->numero = $request->numero;
        $prestation->nom = $request->nom_prestation;
        $prestation->beneficiaire_id = $request->beneficiaire_id;
        // $prestation->client_est_beneficiaire = $request->client_est_beneficiaire;
        $prestation->date_prestation = $request->date_prestation;
        $prestation->methode_paiement = $request->methode_paiement;
        $prestation->montant_ttc = $request->montant_ttc;
        $prestation->save();
        
        return redirect()->back()->with('ok', 'Prestation modifiée avec succès');
    
    }
}
