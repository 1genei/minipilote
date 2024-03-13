<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Model\Evenement;

class EvenementController extends Controller
{
    /*
    * Liste des évènements
    */
    public function index()
    {
        $evenements = Evenements::where('archive', 0)->get();
        return view('evenement.index', compact('evenements'));
    }
}
