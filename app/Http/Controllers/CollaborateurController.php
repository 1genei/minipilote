<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Individu;
use App\Models\Entite;
use App\Models\Typecontact;
use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\EntiteIndividu;
use Auth;
use Crypt;

class CollaborateurController extends Controller
{
      /**
     * Affiche la liste des contacts
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
        return view('collaborateur.index');
    }

      /**
     * Affiche la liste des contacts archivés
     *
     * @return \Illuminate\Http\Response
     */
    public function archives()
    {
    
        return view('collaborateur.archives');
    }

    /**
     * Formulaire de création de collaborateur
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('collaborateur.add');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

     /**
     * Page de modification du contact
     *
     * @param  int  $contact_id
     * @return \Illuminate\Http\Response
     */
    public function edit($contact_id)
    {
        $contact = Contact::where('id', Crypt::decrypt($contact_id))->first();
        if($contact->type == "individu"){
            
            $cont = $contact->individu;
        
        }else{
            $cont = $contact->entite;
        
        }
        $emails = $cont->email != null ? json_decode($cont->email) : [];
        
        return view('collaborateur.edit', compact('contact','cont','emails'));
    }
}
