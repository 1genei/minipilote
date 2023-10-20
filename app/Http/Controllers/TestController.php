<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;

class TestController extends Controller
{
    
    
    /**
    * Page index 
    */
    public function index(){
    
        
        return view('index_test');
    
    }
}
