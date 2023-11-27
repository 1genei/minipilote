<?php

namespace App\Http\Livewire\Contact;

use Livewire\Component;
use App\Models\Contact;
use App\Models\Societe;

use Illuminate\Database\Eloquent\Builder;

class AddForm extends Component
{
    public $raison_sociale;
    public $nom;
    public $nom1;
    public $nom2;
    public $prenom;
    public $prenom1;
    public $prenom2;
    public $profession;
    public $profession1;
    public $profession2;
    public $forme_juridique;
    public $nature;
    // public $emailx;
    public $email;
    public $email1;
    public $email2;
    
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
    public $commercial_id;
    public $societe_id;
    
    public $typecontact;
    public $typecontacts;
    public $displaytypecontact;
    
    public $collaborateurs;
    public $societes;
    
    public function rules()
    {
    

        if ($this->nature == "Personne morale") {

            return [
                'nature' => 'required',
                'raison_sociale' => 'required|string',
                'forme_juridique' => 'required|string',
                // 'emailx' => 'required|string',
                // 'email' => 'required|email|unique:entites',
            ];

        } elseif ($this->nature == "Personne physique") {

            return [
                'nature' => 'required',
                // 'civilite' => 'required|string',
                'nom' => 'required|string',
                'prenom' => 'required|string',
                // 'emailx' => 'required|string',
                // 'email' => 'required|email|unique:individus',
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
                // 'email1' => 'required|email|unique:entites',
                // 'email2' => 'required|email|unique:entites',

            ];

        } else {

            return [
                'nature' => 'required',
                'nom' => 'required|string',
                'type' => 'required|string',
                // 'emailx' => 'required|string',
                // 'email' => 'required|email|unique:entites',

            ];

        }

    }

    public function submit()
    {

        $this->validate();
    }
    
    public function render()
    {
        if($this->typecontact == "Collaborateur"){
            $this->nature = "Personne physique";
        }
        
        
        $this->collaborateurs = Contact::whereHas('typecontacts', function (Builder $query) {
            $query->where('type', 'collaborateur');
        })
            ->where([["type", "individu"], ['archive', false]])
            ->get();
            
        $this->societes = Societe::where('archive', false)->get();

            
        return view('livewire.contact.add-form');
    }
}
