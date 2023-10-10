<?php

namespace App\Http\Livewire\Utilisateur;

use Livewire\Component;
use App\Models\Role;
use App\Models\Individu;

class EditForm extends Component
{ 
public $roles;
    public $contact_existant;
    public $individus;
    public $individu;
    public $nom;   
    public $prenom;    
    public $email;
    public $emailx;
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
    
    
    public function render()
    {
    
        $emails = $cont->email != null ? json_decode($cont->email) : [];
    // dd()
    
        $this->roles = Role::where('archive', false)->get();
        $this->individus = Individu::where('archive', false)->get();
        $this->infosUser = $this->utilisateur?->infos();


        $this->nom = $this->infosUser?->nom;   
        $this->prenom = $this->infosUser?->prenom;    
        $this->email = $this->infosUser?->email;
        $this->numero_voie = $this->infoUser?->numero_voie;
        $this->nom_voie = $this->infoUser?->nom_voie;
        $this->complement_voie = $this->infoUser?->complement_voie;
        $this->code_postal = $this->infoUser?->code_postal;
        $this->ville = $this->infoUser?->ville;
        $this->pays = $this->infoUser?->pays;
        $this->code_insee = $this->infoUser?->code_insee;
        $this->code_cedex = $this->infoUser?->code_cedex;
        $this->numero_cedex = $this->infoUser?->numero_cedex;
        $this->boite_postale = $this->infoUser?->boite_postale;
        $this->residence = $this->infoUser?->residence;
        $this->batiment = $this->infoUser?->batiment;
        $this->escalier = $this->infoUser?->escalier;
        $this->etage = $this->infoUser?->etage;
        $this->porte = $this->infoUser?->porte;
        $this->telephone_fixe = $this->infosUser?->telephone_fixe;
        $this->indicatif_fixe = $this->infosUser?->indicatif_fixe;
        $this->telephone_mobile = $this->infosUser?->telephone_mobile;
        $this->indicatif_mobile = $this->infosUser?->indicatif_mobile;
        $this->civilite = $this->infosUser?->civilite;
        $this->notes = $this->infosUser?->notes;
        $this->role = $this->infosUser?->role;

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