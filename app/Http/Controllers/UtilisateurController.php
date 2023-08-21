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
        
        $contactindividus = Contact::where([["type","individu"], ['archive', false]])->get();     

        return view('utilisateur.add', compact('contactindividus'));
    }
    
    /**
    *  
    */
    public function store(Request $request){

        $typecontact = Typecontact::where('type', $request->type_contact)->first();

        $contact = Contact::create([
            "user_id" => Auth::user()->id,
            "type" => $request->type_contact,
            "nature" => $request->nature,

        ]);
        
        $contact->typeContacts()->attach($typecontact->id);
        
        $rand=rand();
        $password = base64_encode($rand);
        
        
        $user = User::create([
            // 'name' => $request->name,
            'email' => $request->email,
            'contact_id' => $contact->id,
            'password' => Hash::make($password),
        ]);
        
        
        
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
        
        return back()->with('ok', 'Contact ajouté');
        
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
}
