<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Typecontact;
use App\Models\User;
use App\Models\Individu;
use Auth;
use Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth as FacadesAuth;


class UtilisateurController extends Controller
{
    /**
     * Affiche la liste des utilisateurs
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $contactindividus = Contact::where([["type","individu"], ['archive', false]])->get();

        return view('utilisateur.index', compact('contactindividus'));
    }


    /**
     * Affiche la liste des utilisateurs archivés
     *
     * @return \Illuminate\Http\Response
     */
    public function archives()
    {
        return view('utilisateur.archives');
    }
    
     /**
     *Page de création d'un utilisateur
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('utilisateur.add' );
    }
    
    /**
     *Page de modification d'un utilisateur
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id)
    {
        try {
            $user = User::with(['contact.individu'])  // Chargement des relations
                ->where('contact_id', Crypt::decrypt($user_id))
                ->firstOrFail();
            
            // On passe l'utilisateur et ses données liées à la vue
            return view('utilisateur.edit', compact('user'));
            
        } catch (\Exception $e) {
            return back()->with('error', 'Utilisateur non trouvé');
        }
    }
    
    
    /**
    *  Enregistrer un utilisateur 
    */
    public function store(Request $request){
        try {
            DB::beginTransaction();
            
            $typecontact = Typecontact::where('type', $request->type_contact)->first();

            $contact = Contact::create([
                "user_id" => Auth::user()->id,
                "type" => $request->type_contact,
                "nature" => $request->nature,
            ]);
           
            $contact->typeContacts()->attach($typecontact->id);
            
            $rand = "Styl&grip2025";
            $password = $rand;
            
            $user = User::create([
                'email' => $request->email,
                'role_id' => $request->role,
                'contact_id' => $contact->id,
                'password' => Hash::make($password),
            ]);
            
            Individu::create([
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

            DB::commit();
            return back()->with('ok', 'Contact ajouté avec succès');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Une erreur est survenue lors de l\'ajout du contact');
        }
    }
    
    
    
/**
 * Modifier un utilisateur
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $user_id
 * @return \Illuminate\Http\Response
 */        
public function update(Request $request, $user_id)
{
    try {
        DB::beginTransaction();
        
        $user = User::where('id', Crypt::decrypt($user_id))->firstOrFail();
        
        // Validation avec exception de l'email actuel
        $request->validate([
            'email' => 'required|email|unique:users,email,'.$user->id.',id',
            'nom' => 'required',
            'prenom' => 'required',
        ]);

        $contact = $user->contact;

        // Update contact information
        $contact->update([
            "type" => $request->type_contact ?? $contact->type,
            "nature" => $request->nature ?? $contact->nature,
        ]);
        
        $individu = $contact->individu;
        $individu->update([
            "email" => $request->email,
            "nom" => $request->nom,
            "prenom" => $request->prenom,
            
            // Adresse
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
            
            // Informations personnelles
            "civilite" => $request->civilite,
            "date_naissance" => $request->date_naissance,
            "lieu_naissance" => $request->lieu_naissance,
            "nationalite" => $request->nationalite,
            "situation_matrimoniale" => $request->situation_matrimoniale,
            "nom_jeune_fille" => $request->nom_jeune_fille,
            
            // Contacts
            "telephone_fixe" => $request->telephone_fixe,
            "telephone_mobile" => $request->telephone_mobile,
            "indicatif_fixe" => $request->indicatif_fixe,
            "indicatif_mobile" => $request->indicatif_mobile,
            
            // Contacts supplémentaires
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
            
            // Notes
            "notes" => $request->notes,
        ]);

        // Update user email if changed
        if ($user->email !== $request->email) {
            $user->email = $request->email;
            $user->save();
        }

        DB::commit();
        return back()->with('ok', 'Contact modifié avec succès');
        
    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', 'Une erreur est survenue lors de la modification du contact: ' . $e->getMessage());
    }
}


    /**
     * Archiver un user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archiver($user_id)
    {
        $user = User::where('id', Crypt::decrypt($user_id))->first();
        
        $user->archive = true;
        $user->update();
        
        return "200";
    }

     /**
     * Restaurer un user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unarchive($user_id)
    {
        $user = User::where('id', Crypt::decrypt($user_id))->first();
        
        
        $user->archive = false;
        $user->update();
        
        return "200";
    }

    /**
     * Afficher les détails d'un utilisateur
     *
     * @param  string  $user_id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        try {
            $user = User::with(['contact.individu'])  // Chargement des relations
                ->where('contact_id', Crypt::decrypt($user_id))
                ->firstOrFail();
            
            return view('utilisateur.show', compact('user'));
            
        } catch (\Exception $e) {
            return back()->with('error', 'Utilisateur non trouvé');
        }
    }

    /**
     * Mettre à jour le mot de passe d'un utilisateur
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $user_id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, $user_id)
    {
        try {
            $request->validate([
                'password' => 'required|min:8|confirmed',
            ]);

            $user = User::findOrFail(Crypt::decrypt($user_id));
            $user->password = Hash::make($request->password);
            $user->save();

            return back()->with('ok', 'Mot de passe modifié avec succès');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la modification du mot de passe');
        }
    }
}
