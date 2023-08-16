<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Individu;
use App\Models\Entite;
use App\Models\Typecontact;
use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\EntiteIndividu;
use Auth;


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
     * Affiche la liste des contacts archivés
     *
     * @return \Illuminate\Http\Response
     */
    public function archives()
    {
        
        $contactentites = Contact::where([["type","entite"], ['archive', true]])->get();
        $contactindividus = Contact::where([["type","individu"], ['archive', true]])->get();

        return view('contact.archives', compact('contactentites', 'contactindividus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
       $contacts = Contact::where('user_id', Auth::id())->get();
       $contactindividus = Contact::where([["type","individu"], ['archive', false]])->get();
       $typecontacts = Typecontact::where('archive', false)->get();
       return view('contact.add', compact('contactindividus','contacts','typecontacts'));
    }

    /**
     * Enregistrer les contacts
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    


        if ($request->nature == "Personne morale" || $request->nature == "Groupe") {
            $type_contact = "entité";
        } else {
            $type_contact = "individu";
        }
 
        $contact = Contact::create([
            "user_id" => Auth::user()->id,
            "type" => $type_contact,
            "nature" => $request->nature,

        ]);
        
        $typecontact = Typecontact::where('type', $request->typecontact)->first();
        $contact->typeContacts()->attach($typecontact->id);

        if ($type_contact == "individu") {

            Individu::create([
                "email" => $request->emailx,
                "contact_id" => $contact->id,
                "nom" => $request->nom,
                "prenom" => $request->prenom,
                "adresse" => $request->adresse,
                "complement_adresse" => $request->complement_adresse,
                "code_postal" => $request->code_postal,
                "ville" => $request->ville,
                "pays" => $request->pays,

                "civilite" => $request->civilite,
                "date_naissance" => $request->date_naissance,
                "lieu_naissance" => $request->lieu_naissance,
                "nationalite" => $request->nationalite,
                "situation_matrimoniale" => $request->situation_matrimoniale,
                "nom_jeune_fille" => $request->nom_jeune_fille,
                "telephone_fixe" => $request->telephone_fixe,
                "telephone_mobile" => $request->telephone_mobile,

                "civilite1" => $request->civilite1,
                "nom1" => $request->nom1,
                "prenom1" => $request->prenom1,
                "telephone_fixe1" => $request->telephone_fixe1,
                "telephone_mobile1" => $request->telephone_mobile1,
                "email1" => $request->email1,

                "civilite2" => $request->civilite2,
                "nom2" => $request->nom2,
                "prenom2" => $request->prenom2,
                "telephone_fixe2" => $request->telephone_fixe2,
                "telephone_mobile2" => $request->telephone_mobile2,
                "email2" => $request->email2,

                "notes" => $request->notes,

            ]);

        } else {

            Entite::create([
                "type" => $request->type,
                "email" => $request->emailx,
                "nom" => $request->nom,
                "telephone_fixe" => $request->telephone_fixe,
                "telephone_mobile" => $request->telephone_mobile,
                "adresse" => $request->adresse,
                "complement_adresse" => $request->complement_adresse,
                "forme_juridique" => $request->forme_juridique,
                "raison_sociale" => $request->raison_sociale,
                "numero_siret" => $request->numero_siret,
                "code_naf" => $request->code_naf,
                "date_immatriculation" => $request->date_immatriculation,
                "numero_rsac" => $request->numero_rsac,
                "numero_assurance" => $request->numero_assurance,
                "numero_tva" => $request->numero_tva,
                "numero_rcs" => $request->numero_rcs,
                "rib_bancaire" => $request->rib_bancaire,
                "iban" => $request->iban,
                "bic" => $request->bic,
                "site_web" => $request->site_web,
                "pays" => $request->pays,
                "code_postal" => $request->code_postal,
                "ville" => $request->ville,
                "contact_id" => $contact->id,

            ]);

        }

        return redirect()->back()->with('ok', 'Contact ajouté');
        
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
            $entite_id = $contact->entite->id;
           
          
            foreach ($individus_existants as $ind) {
                array_push($ids_existant, $ind->individu->contact->id); 
            }
            
            $newcontacts = Contact::where([['archive', false], ['type', 'individu']])->whereNotIn('id', $ids_existant)->get();

            return view('contact.show_entite', compact('contact', 'newcontacts', 'entite_id'));
        }
    }



    /**
     * Page de modification du contact
     *
     * @param  int  $contact_id
     * @return \Illuminate\Http\Response
     */
    public function edit($contact_id)
    {
    
        $contact = Contact::where('id', Crypt::decrypt($contact_id))->first();
        if($contact->type == "individu"){
            
            $cont = $contact->individu;
        
        }else{
            $cont = $contact->entite;
        
        }
        $typecontact = $contact->typecontacts[0]->type;
        
        $emails = $cont->email != null ? json_decode($cont->email) : [];
        $typecontacts = Typecontact::where('archive', false)->get();
        
        return view('contact.edit', compact('contact','cont','emails','typecontacts','typecontact'));
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
        $contact = Contact::where('id', Crypt::decrypt($contact_id))->first();
        
        if ($request->nature == "Personne morale" || $request->nature == "Groupe") {
            $type_contact = "entité";
        } else {
            $type_contact = "individu";
        }
        $individu = $contact->individu;
        $entite = $contact->entite;

      
        // modifier le type du contact
        
        $typecontact = Typecontact::where('type', $request->typecontact)->first();
        
        
        $contact->typeContacts()->detach();
        $contact->typeContacts()->attach($typecontact->id);
        
        $contact->update();

        if ($type_contact == "individu") {
            $individu->email = $request->emailx;
            $individu->contact_id = $contact->id;
            $individu->nom = $request->nom;
            $individu->prenom = $request->prenom;
            $individu->adresse = $request->adresse;
            $individu->complement_adresse = $request->complement_adresse;
            $individu->code_postal = $request->code_postal;
            $individu->ville = $request->ville;
            $individu->pays = $request->pays;

            $individu->civilite = $request->civilite;
            $individu->date_naissance = $request->date_naissance;
            $individu->lieu_naissance = $request->lieu_naissance;
            $individu->nationalite = $request->nationalite;
            $individu->situation_matrimoniale = $request->situation_matrimoniale;
            $individu->nom_jeune_fille = $request->nom_jeune_fille;
            $individu->telephone_fixe = $request->telephone_fixe;
            $individu->telephone_mobile = $request->telephone_mobile;

            $individu->civilite1 = $request->civilite1;
            $individu->nom1 = $request->nom1;
            $individu->prenom1 = $request->prenom1;
            $individu->telephone_fixe1 = $request->telephone_fixe1;
            $individu->telephone_mobile1 = $request->telephone_mobile1;
            $individu->email1 = $request->email1;

            $individu->civilite2 = $request->civilite2;
            $individu->nom2 = $request->nom2;
            $individu->prenom2 = $request->prenom2;
            $individu->telephone_fixe2 = $request->telephone_fixe2;
            $individu->telephone_mobile2 = $request->telephone_mobile2;
            $individu->email2 = $request->email2;

            $individu->notes = $request->notes;

            $individu->update();

        } else {

            $entite->type = $request->type;
            $entite->email = $request->emailx;
            $entite->nom = $request->nom;
            $entite->telephone_fixe = $request->telephone_fixe;
            $entite->telephone_mobile = $request->telephone_mobile;
            $entite->adresse = $request->adresse;
            $entite->complement_adresse = $request->complement_adresse;
            $entite->forme_juridique = $request->forme_juridique;
            $entite->raison_sociale = $request->raison_sociale;
            $entite->numero_siret = $request->numero_siret;
            $entite->code_naf = $request->code_naf;
            $entite->date_immatriculation = $request->date_immatriculation;
            $entite->numero_rsac = $request->numero_rsac;
            $entite->numero_assurance = $request->numero_assurance;
            $entite->numero_tva = $request->numero_tva;
            $entite->numero_rcs = $request->numero_rcs;
            $entite->rib_bancaire = $request->rib_bancaire;
            $entite->iban = $request->iban;
            $entite->bic = $request->bic;
            $entite->site_web = $request->site_web;
            $entite->pays = $request->pays;
            $entite->code_postal = $request->code_postal;
            $entite->ville = $request->ville;
            $entite->contact_id = $contact->id;

            $entite->update();

        }

        
        session()->flash('ok', 'Post successfully updated.');
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

     /**
     * Restaurer un contact
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unarchive($contact_id)
    {
        $contact = Contact::where('id', Crypt::decrypt($contact_id))->first();
        
        
        $contact->archive = false;
        $contact->update();
        
        return "200";
    }
}
