<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $casts  = ['date_debut' => 'date', 'date_fin' => 'date'];

    
    /*
    * Relation with Circuit
    */
    public function circuit()
    {
        return $this->belongsTo(Circuit::class);
    }
     
    /*
    * Retourne les prestations liees a l'evenement
    */
    public function prestations()
    {
        return $this->hasMany(Prestation::class);
    }
    
    /*
    * Retourne les dépenses liees a l'evenement
    */
    public function depenses(){
        return $this->hasMany('App\Models\depense');
        // return $this->hasMany(Depense::class);
    }
    
    /*
    * Retourne le montant de la recette de l'evenement
    */
    
    public function recette(){
        
       return  $this->prestations?->sum('montant_ttc');
    }
    
    /*
    * Retourne le montant des depenses de l'evenement
    */
    
    public function montantDepenses(){
        
       return  $this->depenses?->sum('montant');
    }
    /*
    * Retourne le montant du bénéfices de l'evenement
    */
    public function benefices(){
        
        $depenses = $this->depenses;
        $total_depenses = 0;
        foreach($depenses as $depense){
            $total_depenses += $depense->montant;
        }
        
        $recette = $this->prestations?->sum('montant_ttc');
        $depenses = $this->depenses?->sum('montant');
        
        return $recette - $depenses ;
    }
}
