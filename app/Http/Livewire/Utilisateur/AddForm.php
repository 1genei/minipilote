<?php

namespace App\Http\Livewire\Utilisateur;

use Livewire\Component;
use App\Models\Role;
use App\Models\Individu;

class AddForm extends Component
{
    public $roles;
    public $contact_existant;
    public $individu;
    public $nom;   
    public $prenom;    
    public $email;
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
    public $contactindividus;
    
    
    public function render()
    {
        $this->roles = Role::where('archive', false)->get();

        return view('livewire.utilisateur.add-form');
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
