<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $guarded =[];
    
    /**
     * Retourne l'individu lié au contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function individu()
    {
        return $this->hasOne(Individu::class);
    }
    
     /**
     * Retourne l'entité liée au contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function entite()
    {
        return $this->hasOne(Entite::class);
    }
    

    /**
     * Retourne les infos du contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function infos()
    {
        if($this->type == "individu"){
            return $this->individu;
        
        }else{
            return $this->entite;
        }
    }
    
    
    /**
     * Retourne l'individu lié au contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function client()
    {
        return $this->hasOne(Client::class);
    }
    
    /**
     * Retourne l'individu lié au contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function fournisseur()
    {
        return $this->hasOne(Fournisseur::class);
    }
}
