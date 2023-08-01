<?php

namespace App\Http\Livewire\Client;

use Livewire\Component;

class AddForm extends Component
{
    public $raison_sociale;
    public $nom;
    public $nom1;
    public $nom2;
    public $prenom;
    public $prenom1;
    public $prenom2;
    public $forme_juridique;
    public $nature;
    public $emailx;
    public $email;
    public $email1;
    public $email2;
    public $ville;
    public $code_postal;
    public $adresse;
    public $complement_adresse;
    public $pays;
    public $numero_siret;
    public $numero_tva;
    public $telephone_fixe;
    public $indicatif_fixe;
    public $telephone_fixe1;
    public $indicatif_fixe1;
    public $telephone_fixe2;
    public $indicatif_fixe2;
    public $telephone_mobile;
    public $indicatif_mobile;
    public $telephone_mobile1;
    public $indicatif_mobile1;
    public $telephone_mobile2;
    public $indicatif_mobile2;
    public $type;
    public $civilite;
    public $civilite1;
    public $civilite2;
    public $notes;
    public $contactindividus;

    public function rules()
    {

        if ($this->nature == "Personne morale") {

            return [
                'nature' => 'required',
                'raison_sociale' => 'required|string',
                'forme_juridique' => 'required|string',
                'emailx' => 'required|string',
                'email' => 'required|email|unique:entites',
            ];

        } elseif ($this->nature == "Personne physique") {

            return [
                'nature' => 'required',
                // 'civilite' => 'required|string',
                'nom' => 'required|string',
                'prenom' => 'required|string',
                'emailx' => 'required|string',
                'email' => 'required|email|unique:individus',
            ];

        } elseif ($this->nature == "Couple") {

            return [
                'nature' => 'required',

                'civilite1' => 'required|string',
                'civilite2' => 'required|string',
                'nom1' => 'required|string',
                'prenom1' => 'required|string',
                'nom2' => 'required|string',
                'prenom2' => 'required|string',
                'email1' => 'required|email|unique:entites',
                'email2' => 'required|email|unique:entites',

            ];

        } else {

            return [
                'nature' => 'required',
                'nom' => 'required|string',
                'type' => 'required|string',
                'emailx' => 'required|string',
                'email' => 'required|email|unique:entites',

            ];

        }

    }

    public function submit()
    {

        $this->validate();
    }

    public function render()
    {
        return view('livewire.client.add-form');
    }
}
