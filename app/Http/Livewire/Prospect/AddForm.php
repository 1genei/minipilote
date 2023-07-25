<?php

namespace App\Http\Livewire\Prospect;

use Livewire\Component;

class AddForm extends Component
{
    public $raison_sociale;
    public $nom;
    public $prenom;
    public $forme_juridique;
    public $nature;
    public $emailx;
    public $email;
    public $contact1;
    public $contact2;

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

            dd("fff");

        } elseif ($this->nature == "Personne physique") {

            return [
                'nature' => 'required',

                'nom' => 'required|string',
                'emailx' => 'required|string',
                'email' => 'required|email|unique:individus',
            ];

        } elseif ($this->nature == "Couple") {

            return [
                'nature' => 'required',

                'nom' => 'required|string',
                'emailx' => 'required|string',
                'email' => 'required|email|unique:entites',
            ];

        } else {

            return [
                'nature' => 'required',
                'nom' => 'required|string',
                'emailx' => 'required|string',
            ];

        }

    }

    public function submit()
    {

        $this->validate();
    }

    public function render()
    {
        return view('livewire.prospect.add-form');
    }
}
