<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
     * The typecontacts that belong to the Contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function typecontacts(): BelongsToMany
    {
        return $this->belongsToMany(Typecontact::class,);
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

    /**
     * Retourne les tags liés au contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'contact_tag', 'contact_id', 'tag_id');
    }

    /**
     * Retourne les notes liées au contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Retourne le secteur d'activité lié au contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function secteurActivite()
    {
        return $this->belongsTo(SecteurActivite::class);
    }

    /**
     * Retourne les événements liés au contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function evenements()
    {
        return $this->belongsToMany(Evenement::class, 'contact_evenement', 'contact_id', 'evenement_id');
    }
}
