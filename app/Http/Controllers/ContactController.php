<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Individu;
use App\Models\Entite;
use App\Models\Typecontact;
use App\Models\EntiteIndividu;
use App\Models\Prestation;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Crypt;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use App\Models\SecteurActivite;


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
    public function store(Request $request, $returnContact = false)
    {
        try {
            DB::beginTransaction();
            
            // Validation des données
            $validated = $request->validate([
                'nature' => 'required',
                'typecontact' => 'required',
                'email' => 'email',
                'nom' => 'required_if:nature,Personne physique',
                'prenom' => 'required_if:nature,Personne physique',
                'raison_sociale' => 'required_if:nature,Personne morale',
                'forme_juridique' => 'required_if:nature,Personne morale',

            ], [
                'nature.required' => 'Le type de contact est obligatoire',
                'typecontact.required' => 'Le type de contact est obligatoire',
                'email.email' => 'L\'email n\'est pas valide',
                'nom.required_if' => 'Le nom est obligatoire pour une personne physique',
                'prenom.required_if' => 'Le prénom est obligatoire pour une personne physique',
                'raison_sociale.required_if' => 'La raison sociale est obligatoire pour une personne morale',
                'forme_juridique.required_if' => 'La forme juridique est obligatoire pour une personne morale',
            ]);

        if ($request->nature == "Personne morale" || $request->nature == "Groupe") {
            $type_contact = "entité";
        } else {
            $type_contact = "individu";
        }

        // Créer ou récupérer le secteur d'activité s'il est fourni
        $secteurActiviteId = null;
        if ($request->secteur_activite) {
            $secteurActivite = SecteurActivite::firstOrCreate(
                ['nom' => $request->secteur_activite],
                ['archive' => false]
            );
            $secteurActiviteId = $secteurActivite->id;
        }

        $contact = Contact::create([
            "user_id" => Auth::user()->id,
            "type" => $type_contact,
            "nature" => $request->nature,
            "commercial_id" => $request->commercial_id,
            "societe_id" => $request->societe_id,
            "secteur_activite_id" => $secteurActiviteId,
            "source_contact" => $request->source_contact
        ]);
        $typecontact = Typecontact::where('type', $request->typecontact)->first();
        $contact->typeContacts()->attach($typecontact->id);
        
        if ($type_contact == "individu") {
            Individu::create([
                "email" => $request->email,
                "contact_id" => $contact->id,
                "nom" => $request->nom,
                "prenom" => $request->prenom,
                "profession" => $request->profession,
                "profession1" => $request->profession1,
                "profession2" => $request->profession2,
                "entreprise" => $request->entreprise,
                "fonction_entreprise" => $request->fonction_entreprise,
                "numero_voie" => $request->numero_voie,
                "nom_voie" => $request->nom_voie,
                "complement_voie" => $request->complement_voie,
                "code_postal" => $request->code_postal,
                "ville" => $request->ville,
                "pays" => $request->pays,
                "code_insee" => $request->code_insee,
                "code_cedex" => $request->code_cedex,
                "numero_cedex" => $request->numero_cedex,
                "boite_postale" => $request->boite_postale,
                "residence" => $request->residence,
                "batiment" => $request->batiment,
                "escalier" => $request->escalier,
                "etage" => $request->etage,
                "porte" => $request->porte, 

                "civilite" => $request->civilite,
                "date_naissance" => $request->date_naissance,
                "lieu_naissance" => $request->lieu_naissance,
                "nationalite" => $request->nationalite,
                "situation_matrimoniale" => $request->situation_matrimoniale,
                "nom_jeune_fille" => $request->nom_jeune_fille,
                "indicatif_fixe" => $request->indicatif_fixe,
                "telephone_fixe" => $request->telephone_fixe,
                "indicatif_mobile" => $request->indicatif_mobile,
                "telephone_mobile" => $request->telephone_mobile,

                "civilite1" => $request->civilite1,
                "nom1" => $request->nom1,
                "prenom1" => $request->prenom1,
                "indicatif_fixe1" => $request->indicatif_fixe1,
                "telephone_fixe1" => $request->telephone_fixe1,
                "indicatif_mobile1" => $request->indicatif_mobile1,
                "telephone_mobile1" => $request->telephone_mobile1,
                "email1" => $request->email1,

                "civilite2" => $request->civilite2,
                "nom2" => $request->nom2,
                "prenom2" => $request->prenom2,
                "indicatif_fixe2" => $request->indicatif_fixe2,
                "telephone_fixe2" => $request->telephone_fixe2,
                "indicatif_mobile2" => $request->indicatif_mobile2,
                "telephone_mobile2" => $request->telephone_mobile2,
                "email2" => $request->email2,

                "notes" => $request->notes,
            ]);

        } else {
            Entite::create([
                "type" => $request->type,
                "email" => $request->email,
                "nom" => $request->nom,
                "indicatif_fixe" => $request->indicatif_fixe,
                "telephone_fixe" => $request->telephone_fixe,
                "indicatif_mobile" => $request->indicatif_mobile,
                "telephone_mobile" => $request->telephone_mobile,
                "numero_voie" => $request->numero_voie,
                "nom_voie" => $request->nom_voie,
                "complement_voie" => $request->complement_voie,
                "code_postal" => $request->code_postal,
                "ville" => $request->ville,
                "pays" => $request->pays,
                "code_insee" => $request->code_insee,
                "code_cedex" => $request->code_cedex,
                "numero_cedex" => $request->numero_cedex,
                "boite_postale" => $request->boite_postale,
                "residence" => $request->residence,
                "batiment" => $request->batiment,
                "escalier" => $request->escalier,
                "etage" => $request->etage,
                "porte" => $request->porte, 
                
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
                "contact_id" => $contact->id,
                "notes" => $request->notes,
                ]);
            }
            

            if ($request->has('tags') && !empty($request->tags)) {
                try {
                    $tagIds = [];
                    foreach ($request->tags as $tagName) {
                        if (!empty(trim($tagName))) {
                            $tag = Tag::firstOrCreate([
                                'nom' => trim($tagName)
                            ]);
                            $tagIds[] = $tag->id;
                        }
                    }
                    if (!empty($tagIds)) {
                        $contact->tags()->sync($tagIds);
                    }
                } catch (\Exception $e) {
                    \Log::error('Erreur lors de la synchronisation des tags : ' . $e->getMessage());
                    // Continue l'exécution même si les tags échouent
                }

        }
        
        if($returnContact == true) return $contact;
        
            DB::commit();
        return redirect()->route('contact.show', Crypt::encrypt($contact->id))->with('ok', 'Contact ajouté');
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withErrors(['error' => 'Une erreur est survenue lors de la création du contact'])
                ->withInput();
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
      
        $derniere_prestation = Prestation::orderBy('created_at', 'desc')->first();
        
        if($derniere_prestation){
            $prochain_numero_prestation = $derniere_prestation->numero + 1;
        }else{
            $prochain_numero_prestation = 45264;
        }
    
        $beneficiaires = Contact::where([['archive', false], ['type', 'individu']])->get();
    
        if($contact->type == "individu"){
            return view('contact.show_individu', compact('contact', 'prochain_numero_prestation','beneficiaires'));
            
        }else{
        
        
            $individus_existants = EntiteIndividu::where([['entite_id', $contact->entite->id]])->get();
            $ids_existant = array();
            $entite_id = $contact->entite->id;
           
      
            foreach ($individus_existants as $ind) {
                array_push($ids_existant, $ind->individu->contact->id); 
            }
            
            $newcontacts = Contact::where([['archive', false], ['type', 'individu']])->whereNotIn('id', $ids_existant)->get();

            return view('contact.show_entite', compact('contact', 'newcontacts', 'entite_id','prochain_numero_prestation','beneficiaires'));
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
        
        $typecontacts = Typecontact::where('archive', false)->get();
        
        
        return view('contact.edit', compact('contact','cont','typecontacts','typecontact'));
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
        try {
            DB::beginTransaction();
        
            $contact = Contact::findOrFail($contact_id);

         
            // Validation des données
            $validated = $request->validate([
                'nature' => 'required',
                'typecontact' => 'required',
                'nom' => 'required_if:nature,Personne physique',
                'prenom' => 'required_if:nature,Personne physique',
                'raison_sociale' => 'required_if:nature,Personne morale',
                'forme_juridique' => 'required_if:nature,Personne morale',
                
            ], [
                'nature.required' => 'Le type de contact est obligatoire',
                'typecontact.required' => 'Le type de contact est obligatoire',
                'nom.required_if' => 'Le nom est obligatoire pour une personne physique',
                'prenom.required_if' => 'Le prénom est obligatoire pour une personne physique',
                'raison_sociale.required_if' => 'La raison sociale est obligatoire pour une personne morale',
                'forme_juridique.required_if' => 'La forme juridique est obligatoire pour une personne morale',
            ]);

            // Créer ou récupérer le secteur d'activité s'il est fourni
            $secteurActiviteId = null;
            if ($request->secteur_activite) {
                $secteurActivite = SecteurActivite::firstOrCreate(
                    ['nom' => $request->secteur_activite],
                    ['archive' => false]
                );
                $secteurActiviteId = $secteurActivite->id;
            }

            $contact->update([
                "commercial_id" => $request->commercial_id,
                "societe_id" => $request->societe_id,
                "secteur_activite_id" => $secteurActiviteId,
                "source_contact" => $request->source_contact
            ]);

            if ($contact->type == "individu") {
                $individu = $contact->individu;
                $individu->update([
                    "email" => $request->email,
                    "nom" => $request->nom,
                    "prenom" => $request->prenom,
                    "profession" => $request->profession,
                    "profession1" => $request->profession1,
                    "profession2" => $request->profession2,
                    "entreprise" => $request->entreprise,
                    "fonction_entreprise" => $request->fonction_entreprise,
                    "numero_voie" => $request->numero_voie,
                    "nom_voie" => $request->nom_voie,
                    "complement_voie" => $request->complement_voie,
                    "code_postal" => $request->code_postal,
                    "ville" => $request->ville,
                    "pays" => $request->pays,
                    "code_insee" => $request->code_insee,
                    "code_cedex" => $request->code_cedex,
                    "numero_cedex" => $request->numero_cedex,
                    "boite_postale" => $request->boite_postale,
                    "residence" => $request->residence,
                    "batiment" => $request->batiment,
                    "escalier" => $request->escalier,
                    "etage" => $request->etage,
                    "porte" => $request->porte,
                    "civilite" => $request->civilite,
                    "date_naissance" => $request->date_naissance,
                    "notes" => $request->notes,
                    // ... autres champs
                ]);
        } else {
                $entite = $contact->entite;
                $entite->update([
                    "type" => $request->type,
                    "email" => $request->email,
                    "nom" => $request->nom,
                    "indicatif_fixe" => $request->indicatif_fixe,
                    "telephone_fixe" => $request->telephone_fixe,
                    "indicatif_mobile" => $request->indicatif_mobile,
                    "telephone_mobile" => $request->telephone_mobile,
                    "numero_voie" => $request->numero_voie,
                    "nom_voie" => $request->nom_voie,
                    "complement_voie" => $request->complement_voie,
                    "code_postal" => $request->code_postal,
                    "ville" => $request->ville,
                    "pays" => $request->pays,
                    "code_insee" => $request->code_insee,
                    "code_cedex" => $request->code_cedex,
                    "numero_cedex" => $request->numero_cedex,
                    "boite_postale" => $request->boite_postale,
                    "residence" => $request->residence,
                    "batiment" => $request->batiment,
                    "escalier" => $request->escalier,
                    "etage" => $request->etage,
                    "porte" => $request->porte, 
                    
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
                    "contact_id" => $contact->id,
                    "notes" => $request->notes,
                ]);
            }

            
            // Gestion des tags
            if ($request->has('tags') && !empty($request->tags)) {
                try {
                    $tagIds = [];
                    foreach ($request->tags as $tagName) {
                        if (!empty(trim($tagName))) {
                            $tag = Tag::firstOrCreate([
                                'nom' => trim($tagName)
                            ]);
                            $tagIds[] = $tag->id;
                        }
                    }
                    if (!empty($tagIds)) {
                        $contact->tags()->sync($tagIds);
                    }
                } catch (\Exception $e) {
                    \Log::error('Erreur lors de la synchronisation des tags : ' . $e->getMessage());
                    // Continue l'exécution même si les tags échouent
                }
            } else {
                // Si aucun tag n'est envoyé, on supprime tous les tags
                $contact->tags()->sync([]);
            }

            DB::commit();
            return redirect()
                ->route('contact.show', Crypt::encrypt($contact->id))
                ->with('ok', 'Contact modifié avec succès');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withErrors(['error' => 'Une erreur est survenue lors de la modification du contact'])
                ->withInput();
        }
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
        
      
    //   dd($request->all());
        
        if($request->contact_existant){

            // $entite->individus()->syncWithoutDetaching($request->newcontacts);
            $entite->individus()->attach($request->newcontact, ['poste' => $request->poste] );
            
        }else{
            
            $contact = $this->store($request, true);
            $entite->individus()->attach($contact->individu->id, ['poste' => $request->poste] );
        
            // $entite->individus()->syncWithoutDetaching($contact->individu->id);
        }
        
        
        return redirect()->back()->with('ok', 'Individu associé');

        
    }
    
    
    /**
     * Associer des individu à une entité
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dissocier_individu($entite_id, $individu_id)
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
