<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;
    
    
    protected $guarded =[];
    protected $dates = ['date_deb','date_fin'];
    
    
    
    
    /**
     * Get the contact that owns the Agenda
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    
    /**
     * Get the user that owns the Agenda
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public static function nb_taches($type_tache = "a_faire"){
    
    
        if($type_tache =="a_faire"){
            $nb_taches = Agenda::where([['est_terminee', false], ['date_deb', '>=', date('Y-m-d')]])->count();
            
        }elseif($type_tache == "en_retard"){
            $nb_taches = Agenda::where([['est_terminee', false], ['date_deb', '<', date('Y-m-d')]])->count();
        
        }elseif($type_tache == "toutes"){
            $nb_taches = Agenda::all()->count();
        
        }
        else{        
            $nb_taches = "erreur de paramètre";
        }
        
        return $nb_taches;
       
    } 
}
