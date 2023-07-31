<?php

namespace App\Http\Livewire\Prospect;

use Livewire\Component;

class EditForm extends Component
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

    public $contact;
    public $cont;
    public $emails;
    
    
    public function mount(){
    

        $this->nature = $this->contact->nature;
        $this->raison_sociale = $this->cont->raison_sociale;
        $this->forme_juridique = $this->cont->forme_juridique;
        $this->nom =  $this->cont->nom;
        $this->nom1 =  $this->cont->nom1;
        $this->nom2 =  $this->cont->nom2;
        $this->prenom =  $this->cont->prenom;
        $this->prenom1 =  $this->cont->prenom1;
        $this->prenom2 =  $this->cont->prenom2;
        $this->emailx =  $this->cont->emailx;
        $this->email =  sizeof($this->emails) > 0 ? $this->emails[0] : "" ;
        $this->email1 =  $this->cont->email1;
        $this->email2 =  $this->cont->email2;
        $this->ville =  $this->cont->ville;
        $this->code_postal =  $this->cont->code_postal;
        $this->adresse =  $this->cont->adresse;
        $this->complement_adresse =  $this->cont->complement_adresse;
        $this->pays =  $this->cont->pays;
        $this->numero_siret =  $this->cont->numero_siret;
        $this->numero_tva =  $this->cont->numero_tva;
        $this->telephone_fixe =  $this->cont->telephone_fixe;
        $this->indicatif_fixe =  $this->cont->indicatif_fixe;
        $this->telephone_fixe1 =  $this->cont->telephone_fixe1;
        $this->indicatif_fixe1 =  $this->cont->indicatif_fixe1;
        $this->telephone_fixe2 =  $this->cont->telephone_fixe2;
        $this->indicatif_fixe2 =  $this->cont->indicatif_fixe2;
        $this->telephone_mobile =  $this->cont->telephone_mobile;
        $this->indicatif_mobile =  $this->cont->indicatif_mobile;
        $this->telephone_mobile1 =  $this->cont->telephone_mobile1;
        $this->indicatif_mobile1 =  $this->cont->indicatif_mobile1;
        $this->telephone_mobile2 =  $this->cont->telephone_mobile2;
        $this->indicatif_mobile2 =  $this->cont->indicatif_mobile2;
        $this->type =  $this->cont->type;
        $this->civilite =  $this->cont->civilite;
        $this->civilite1 =  $this->cont->civilite1;
        $this->civilite2 =  $this->cont->civilite2;
        $this->notes =  $this->cont->notes;
        
    }
    
    public function rules()
    {

        if ($this->nature == "Personne morale") {

            return [
                'nature' => 'required',
                'raison_sociale' => 'required|string',
                'forme_juridique' => 'required|string',
                // 'emailx' => 'required|string',
                'email' => 'required|email|unique:entites',
            ];

        } elseif ($this->nature == "Personne physique") {
    
            return [
                'nature' => 'required',
                // 'civilite' => 'required|string',
                'nom' => 'required|string',
                'prenom' => 'required|string',
                // 'emailx' => 'required|string',
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
        return view('livewire.prospect.edit-form');
    }
}
