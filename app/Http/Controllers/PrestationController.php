<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestation;
use App\Models\Contact;
use App\Models\Individu;
use App\Models\Typecontact;
use App\Models\Evenement;
use App\Models\Produit;
use App\Models\Voiture;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PrestationController extends Controller
{

    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        $prestations = Prestation::orderBy('created_at', 'desc')->get();
        $montant_total_prestations = Prestation::sum('montant_ttc');
        
        return view('prestation.index', compact('prestations', 'montant_total_prestations'));
    }
    
    /**
    * enregistrer une prestation
    */
    public function store(Request $request)
    {
    
       
        
        $request->validate([
            'numero' => 'required|integer|unique:prestations',
            // 'client_id' => 'required|integer',
        ]);
        
 
        $type_contact = "individu";


        // Client
        
        if(!$request->client_existant && $request->client_id == null){
            $contact_client = Contact::create([
                "user_id" => Auth::user()->id,
                "type" => $type_contact,
                "nature" => $request->nature,
            ]);
            
            $client = Individu::create([
                "email" => $request->email_client,
                "contact_id" => $contact_client->id,
                "nom" => $request->nom_client,
                "prenom" => $request->prenom_client,
              
                "numero_voie" => $request->numero_voie_client,
                "nom_voie" => $request->nom_voie_client,
                "complement_voie" => $request->complement_voie_client,
                "code_postal" => $request->code_postal_client,
                "ville" => $request->ville_client,
                "pays" => $request->pays_client,
    
                "civilite" => $request->civilite_client,
               
                "indicatif_fixe" => $request->indicatif_fixe_client,
                "telephone_fixe" => $request->telephone_fixe_client,
                "indicatif_mobile" => $request->indicatif_mobile_client,
                "telephone_mobile" => $request->telephone_mobile_client,
    
                "notes" => $request->notes_client,
    
            ]);
        }else{
            $contact_client = Contact::where('id', $request->client_id)->first();
        }
       
        
        $typecontact = Typecontact::where('type', "Client")->first();
        $contact_client->typeContacts()->syncWithoutDetaching($typecontact->id);

        
        
        
        
        
        
        // Bénéficiaire
        if(!$request->contact_existant){
            $contact = Contact::create([
                "user_id" => Auth::user()->id,
                "type" => $type_contact,
                "nature" => $request->nature,
            ]);
            
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
            
        }else{
            $contact = Contact::where('id', $request->newcontact)->first();
        }
       
        
        $typecontact = Typecontact::where('type', $request->typecontact)->first();
        $contact->typeContacts()->syncWithoutDetaching($typecontact->id);
        
   
        
               
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
        $prestation->notes = $request->notes;
        $prestation->save();
        
        return redirect()->back()->with('ok', 'Prestation enregistrée avec succès');
    }
    
    
    /**
    * Display the specified resource.
    */
    public function show($prestation_id){
    
        $prestation = Prestation::where('id', Crypt::decrypt($prestation_id))->first();
        $newcontacts = Contact::where([['archive', false], ['type', 'individu']])->get();
        
        return view('prestation.show', compact('prestation','newcontacts'));
    
    }
    
    /**
    * create the specified resource.
    */
    public function create($evenement_id = null){
        
        
        $beneficiaires = Contact::where([['archive', false], ['type', 'individu']])->get();
        $prochain_numero_prestation = Prestation::max('numero') + 1;
        $contactclients = Contact::where('archive', false)->get();
        
        $evenement = $evenement_id != null ? Evenement::where('id', Crypt::decrypt($evenement_id))->first() : null;
        $produits = Produit::where([['archive', false],['a_declinaison', 0]])->get();
        $voitures = Voiture::where('archive', false)->get();
        
        return view('prestation.add', compact('beneficiaires', 'prochain_numero_prestation', 'contactclients', 'evenement', 'produits', 'voitures'));
    
    }
    
    
    /**
    * edit the specified resource.
    */
    public function edit($prestation_id){
    
        $prestation = Prestation::where('id', Crypt::decrypt($prestation_id))->first();
        $contactbeneficiaires = Contact::where([['archive', false], ['type', 'individu']])->get();
        $contactclients = Contact::where('archive', false)->get();

        
        return view('prestation.edit', compact('prestation','contactbeneficiaires','contactclients'));
    
    }
    
    /**
    * update the specified resource.
    */
    public function update(Request $request, $prestation_id){
    
        $prestation = Prestation::where('id', Crypt::decrypt($prestation_id))->first();
        
        $request->validate([
            'numero' => 'required|integer',
        ]);
        
        // dd($request->all());
        $prestation->numero = $request->numero;
        $prestation->nom = $request->nom_prestation;
        $prestation->client_id= $request->client_id;
        $prestation->beneficiaire_id = $request->beneficiaire_id;
        // $prestation->client_est_beneficiaire = $request->client_est_beneficiaire;
        $prestation->date_prestation = $request->date_prestation;
        $prestation->methode_paiement = $request->methode_paiement;
        $prestation->montant_ttc = $request->montant_ttc;
        $prestation->notes = $request->notes;
        $prestation->save();
        
        return redirect()->back()->with('ok', 'Prestation modifiée avec succès');
    
    }
    
    /*
    * Liste des prestations archivées
    */
    public function archives(){
    
        $prestations = Prestation::where('archive', true)->get();
        return view('prestation.archives', compact('prestations'));
    
    }
    
    
    /**
    * archive the specified resource.
    */
    public function archive($prestation_id){
    
        $prestation = Prestation::where('id', Crypt::decrypt($prestation_id))->first();
        $prestation->archive = true;
        $prestation->save();
        return "ok";
        
        return redirect()->back()->with('ok', 'Prestation archivée avec succès');
    
    }
    
    /**
    * unarchive the specified resource.
    */
    public function unarchive($prestation_id){
    
        $prestation = Prestation::where('id', Crypt::decrypt($prestation_id))->first();
        $prestation->archive = false;
        $prestation->save();
        return "ok";
        return redirect()->back()->with('ok', 'Prestation désarchivée avec succès');
    
    }
    
    /**
    * delete the specified resource.
    */
    public function delete($prestation_id){
    
        $prestation = Prestation::where('id', Crypt::decrypt($prestation_id))->first();
        $prestation->delete();
        
        return redirect()->back()->with('ok', 'Prestation supprimée avec succès');
    
    }
    
   
    
    
}
