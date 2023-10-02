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
    public $ville;
    public $code_postal;
    public $adresse;
    public $complement_adresse;
    public $pays;
    public $telephone_fixe;
    public $indicatif_fixe;
    public $telephone_mobile;
    public $indicatif_mobile;
    public $civilite;
    public $notes;
    public $role;
    public $utilisateur;
    public $contactindividus;
    
    
    public function render()
    {
        $this->roles = Role::where('archive', false)->get();
        $this->individus = Individu::where('archive', false)->get();



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