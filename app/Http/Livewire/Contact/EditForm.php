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


        $this->nature = old("nature") != null ? old("nature") : $this->contact->nature;
        $this->raison_sociale = old("raison_sociale") != null ? old("raison_sociale") : $this->cont->raison_sociale;
        $this->forme_juridique = old("forme_juridique") != null ? old("forme_juridique") : $this->cont->forme_juridique;
        $this->nom = old("nom") != null ? old("nom") :  $this->cont->nom;
        $this->nom1 = old("nom1") != null ? old("nom1") :  $this->cont->nom1;
        $this->nom2 = old("nom2") != null ? old("nom2") :  $this->cont->nom2;
        $this->prenom = old("prenom") != null ? old("prenom") :  $this->cont->prenom;
        $this->prenom1 = old("prenom1") != null ? old("prenom1") :  $this->cont->prenom1;
        $this->prenom2 = old("prenom2") != null ? old("prenom2") :  $this->cont->prenom2;
        $this->profession = old("profession") != null ? old("profession") :  $this->cont->profession;
        $this->profession1 = old("profession1") != null ? old("profession1") :  $this->cont->profession1;
        $this->profession2 = old("profession2") != null ? old("profession2") :  $this->cont->profession2;
        $this->email = old("email") != null ? old("email") :  $this->cont->email;
        // $this->email =  sizeof($this->emails) > 0 ? $this->emails[0] : "" ;
        $this->email1 = old("email1") != null ? old("email1") :  $this->cont->email1;
        $this->email2 = old("email2") != null ? old("email2") :  $this->cont->email2;
        $this->commercial_id = old("commercial_id") != null ? old("commercial_id") : $this->contact->commercial_id;
        $this->societe_id = old("societe_id") != null ? old("societe_id") : $this->contact->societe_id;
        
        $this->numero_voie = old("numero_voie") != null ? old("numero_voie") : $this->cont->numero_voie;
        $this->nom_voie = old("nom_voie") != null ? old("nom_voie") : $this->cont->nom_voie;
        $this->complement_voie = old("complement_voie") != null ? old("complement_voie") : $this->cont->complement_voie;
        $this->code_postal = old("code_postal") != null ? old("code_postal") : $this->cont->code_postal;
        $this->ville = old("ville") != null ? old("ville") : $this->cont->ville;
        $this->pays = old("pays") != null ? old("pays") : $this->cont->pays;
        $this->code_insee = old("code_insee") != null ? old("code_insee") : $this->cont->code_insee;
        $this->code_cedex = old("code_cedex") != null ? old("code_cedex") : $this->cont->code_cedex;
        $this->numero_cedex = old("numero_cedex") != null ? old("numero_cedex") : $this->cont->numero_cedex;
        $this->boite_postale = old("boite_postale") != null ? old("boite_postale") : $this->cont->boite_postale;
        $this->residence = old("residence") != null ? old("residence") : $this->cont->residence;
        $this->batiment = old("batiment") != null ? old("batiment") : $this->cont->batiment;
        $this->escalier = old("escalier") != null ? old("escalier") : $this->cont->escalier;
        $this->etage = old("etage") != null ? old("etage") : $this->cont->etage;
        $this->porte = old("porte") != null ? old("porte") : $this->cont->porte;
        
        $this->numero_siret = old("numero_siret") != null ? old("numero_siret") :  $this->cont->numero_siret;
        $this->numero_tva = old("numero_tva") != null ? old("numero_tva") :  $this->cont->numero_tva;
        $this->telephone_fixe = old("telephone_fixe") != null ? old("telephone_fixe") :  $this->cont->telephone_fixe;
        $this->indicatif_fixe = old("indicatif_fixe") != null ? old("indicatif_fixe") :  $this->cont->indicatif_fixe;
        $this->telephone_fixe1 = old("telephone_fixe1") != null ? old("telephone_fixe1") :  $this->cont->telephone_fixe1;
        $this->indicatif_fixe1 = old("indicatif_fixe1") != null ? old("indicatif_fixe1") :  $this->cont->indicatif_fixe1;
        $this->telephone_fixe2 = old("telephone_fixe2") != null ? old("telephone_fixe2") :  $this->cont->telephone_fixe2;
        $this->indicatif_fixe2 = old("indicatif_fixe2") != null ? old("indicatif_fixe2") :  $this->cont->indicatif_fixe2;
        $this->telephone_mobile = old("telephone_mobile") != null ? old("telephone_mobile") :  $this->cont->telephone_mobile;
        $this->indicatif_mobile = old("indicatif_mobile") != null ? old("indicatif_mobile") :  $this->cont->indicatif_mobile;
        $this->telephone_mobile1 = old("telephone_mobile1") != null ? old("telephone_mobile1") :  $this->cont->telephone_mobile1;
        $this->indicatif_mobile1 = old("indicatif_mobile1") != null ? old("indicatif_mobile1") :  $this->cont->indicatif_mobile1;
        $this->telephone_mobile2 = old("telephone_mobile2") != null ? old("telephone_mobile2") :  $this->cont->telephone_mobile2;
        $this->indicatif_mobile2 = old("indicatif_mobile2") != null ? old("indicatif_mobile2") :  $this->cont->indicatif_mobile2;
        $this->type = old("type") != null ? old("type") :  $this->cont->type;
        $this->civilite = old("civilite") != null ? old("civilite") :  $this->cont->civilite;
        $this->civilite1 = old("civilite1") != null ? old("civilite1") :  $this->cont->civilite1;
        $this->civilite2 = old("civilite2") != null ? old("civilite2") :  $this->cont->civilite2;
        $this->notes = old("notes") != null ? old("notes") :  $this->cont->notes;
        
    }
    
    public function rules()
    {


        if ($this->nature == "Personne morale") {

            return [
                'nature' => 'required',
                'raison_sociale' => 'required|string',
                'forme_juridique' => 'required|string',
                // 'email' => 'required|email|unique:entites',
            ];

        } elseif ($this->nature == "Personne physique") {
    
            return [
                'nature' => 'required',
                'nom' => 'required|string',
                'prenom' => 'required|string',
                // 'email' => 'required|email|unique:individus',
            ];

        } else {

            return [
                'nature' => 'required',
                'nom' => 'required|string',
                'type' => 'required|string',
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
