<?php

namespace App\Http\Livewire\Contact;

use Livewire\Component;
use App\Models\Contact;
use App\Models\Societe;
use Illuminate\Database\Eloquent\Builder;

class EditForm extends Component
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

    public $contact;
    public $cont;
    public $emails;
    public $typecontact;
       
    public $typecontacts;
    public $displaytypecontact;
    public $commercial_id;
    public $societe_id;
    
    public $collaborateurs;
    public $societes;
    
    
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
        $this->profession =  $this->cont->profession;
        $this->profession1 =  $this->cont->profession1;
        $this->profession2 =  $this->cont->profession2;
        $this->email =  $this->cont->email;
        // $this->email =  sizeof($this->emails) > 0 ? $this->emails[0] : "" ;
        $this->email1 =  $this->cont->email1;
        $this->email2 =  $this->cont->email2;
        $this->commercial_id = $this->contact->commercial_id;
        $this->societe_id = $this->contact->societe_id;
        
        $this->numero_voie = $this->cont->numero_voie;
        $this->nom_voie = $this->cont->nom_voie;
        $this->complement_voie = $this->cont->complement_voie;
        $this->code_postal = $this->cont->code_postal;
        $this->ville = $this->cont->ville;
        $this->pays = $this->cont->pays;
        $this->code_insee = $this->cont->code_insee;
        $this->code_cedex = $this->cont->code_cedex;
        $this->numero_cedex = $this->cont->numero_cedex;
        $this->boite_postale = $this->cont->boite_postale;
        $this->residence = $this->cont->residence;
        $this->batiment = $this->cont->batiment;
        $this->escalier = $this->cont->escalier;
        $this->etage = $this->cont->etage;
        $this->porte = $this->cont->porte;
        
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
       
        return view('livewire.contact.edit-form');
    }
}
