<?php

namespace App\Http\Livewire\Utilisateur;

use Livewire\Component;
use App\Models\Role;
use App\Models\Individu;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class EditForm extends Component
{ 
    public $user;
public $roles;
    public $contact_existant;
    public $individus;
    public $individu;
    public $nom;   
    public $prenom;    
    public $email;
    // public $emailx;
    public $numero_voie;
    public $nom_voie;
    public $complement_voie;
    public $code_postal;
    public $ville;
    public $pays;
    public $code_insee;
    public $code_cedex;
    public $numero_cedex;
    public $boite_postale;
    public $residence;
    public $batiment;
    public $escalier;
    public $etage;
    public $porte;
    public $telephone_fixe;
    public $indicatif_fixe;
    public $telephone_mobile;
    public $indicatif_mobile;
    public $civilite;
    public $notes;
    public $role;
    public $utilisateur;
    public $contactindividus;
    public $infosUser;
    public $date_naissance;
    public $lieu_naissance;
    public $nationalite;
    public $situation_matrimoniale;
    public $nom_jeune_fille;
    public $civilite1;
    public $nom1;
    public $prenom1;
    public $telephone_fixe1;
    public $telephone_mobile1;
    public $email1;
    public $civilite2;
    public $nom2;
    public $prenom2;
    public $telephone_fixe2;
    public $telephone_mobile2;
    public $email2;
    
    public function mount(User $user)
    {
        $this->user = $user;
        
        // Informations de base
        $this->email = $user->email;
        $this->nom = $user->contact->individu->nom;
        $this->prenom = $user->contact->individu->prenom;
        
        // Adresse
        $this->numero_voie = $user->contact->individu->numero_voie;
        $this->nom_voie = $user->contact->individu->nom_voie;
        $this->complement_voie = $user->contact->individu->complement_voie;
        $this->code_postal = $user->contact->individu->code_postal;
        $this->ville = $user->contact->individu->ville;
        $this->pays = $user->contact->individu->pays;
        $this->code_insee = $user->contact->individu->code_insee;
        $this->code_cedex = $user->contact->individu->code_cedex;
        $this->numero_cedex = $user->contact->individu->numero_cedex;
        $this->boite_postale = $user->contact->individu->boite_postale;
        $this->residence = $user->contact->individu->residence;
        $this->batiment = $user->contact->individu->batiment;
        $this->escalier = $user->contact->individu->escalier;
        $this->etage = $user->contact->individu->etage;
        $this->porte = $user->contact->individu->porte;
        
        // Téléphones et indicatifs
        $this->telephone_fixe = $user->contact->individu->telephone_fixe;
        $this->telephone_mobile = $user->contact->individu->telephone_mobile;
        $this->indicatif_fixe = $user->contact->individu->indicatif_fixe;
        $this->indicatif_mobile = $user->contact->individu->indicatif_mobile;
        
        // Informations personnelles
        $this->civilite = $user->contact->individu->civilite;
        $this->date_naissance = $user->contact->individu->date_naissance;
        $this->lieu_naissance = $user->contact->individu->lieu_naissance;
        $this->nationalite = $user->contact->individu->nationalite;
        $this->situation_matrimoniale = $user->contact->individu->situation_matrimoniale;
        $this->nom_jeune_fille = $user->contact->individu->nom_jeune_fille;
        
        // Contacts supplémentaires 1
        $this->civilite1 = $user->contact->individu->civilite1;
        $this->nom1 = $user->contact->individu->nom1;
        $this->prenom1 = $user->contact->individu->prenom1;
        $this->telephone_fixe1 = $user->contact->individu->telephone_fixe1;
        $this->telephone_mobile1 = $user->contact->individu->telephone_mobile1;
        $this->email1 = $user->contact->individu->email1;
        
        // Contacts supplémentaires 2
        $this->civilite2 = $user->contact->individu->civilite2;
        $this->nom2 = $user->contact->individu->nom2;
        $this->prenom2 = $user->contact->individu->prenom2;
        $this->telephone_fixe2 = $user->contact->individu->telephone_fixe2;
        $this->telephone_mobile2 = $user->contact->individu->telephone_mobile2;
        $this->email2 = $user->contact->individu->email2;
        
        // Notes
        $this->notes = $user->contact->individu->notes;
        
        // Autres informations
        $this->roles = Role::where('archive', false)->get();
        $this->individus = Individu::where('archive', false)->get();
        $this->role = $user->role_id;
    }

    public function render()
    {
        return view('livewire.utilisateur.edit-form');
    }
    
    public function rules()
    {      

        return [
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:individus',
        ];

    }

    public function submit()
    {

        $this->validate();
    }
}