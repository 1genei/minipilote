<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Imageproduit;
use App\Models\Stock;
use App\Models\Marque;
use App\Models\Categorieproduit;
use App\Models\Caracteristique;
use Crypt;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class ProduitController extends Controller
{

    private $images_path;

    public function __construct()
    {
       $this->images_path = public_path('/images/images_produits');
    }
    
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $produits = Produit::where('archive', false)->get();
        
        $categories = Categorieproduit::where([['parent_id', null], ['archive',false]])->get();
        return view('produit.index',compact('categories'));
        // return view('produit.index', compact('produits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    
        $categories = Categorieproduit::where([['parent_id', null], ['archive',false]])->get();
        $marques = Marque::where('archive', false)->get();
    
 
        return view('produit.add', compact('categories','marques'));
        
    }

    /**
     * Création d'un produit
     */
    public function store(Request $request)
    {
        
   
        $produit = Produit::create([
            "nom" => $request->nom,
            "description" => $request->description,
            "reference" => $request->reference,
            "user_id" => Auth::user()->id,
            "marque_id" => $request->marque,
            "prix_vente_ht" => $request->prix_vente_ht,
            "prix_vente_ttc" => $request->prix_vente_ttc,
            "prix_vente_max_ht" => $request->prix_vente_max_ht,
            "prix_vente_max_ttc" => $request->prix_vente_max_ttc,
            "prix_achat_ht" => $request->prix_achat_ht,
            "prix_achat_ttc" => $request->prix_achat_ttc,
            "prix_achat_commerciaux_ht" => $request->prix_achat_commerciaux_ht,
            "prix_achat_commerciaux_ttc" => $request->prix_achat_commerciaux_ttc,
            "gerer_stock" => $request->gerer_stock ? true : false,
         
        ]);
        
        if($request->categories_id){
            $produit->categorieproduits()->attach($request->categories_id);
        }
        
        
      
        // stock
        if( $request->gerer_stock){
        
            $stock = Stock::create([
                "produit_id" => $produit->id,
                "quantite" => $request->quantite,
                "quantite_min" => $request->quantite_min_vente,
                "seuil_alerte" => $request->seuil_alerte_stock,
               
            ]);
            
        }
       
        if($request->hasFile('fiche_technique')){
         
            $filename = 'fiche_technique_'.$produit->id.'.pdf';
            $produit->fiche_technique = $filename;
            $request->fiche_technique->storeAs('public/fiche_technique',$filename);
            $produit->update();            
        }
        
        
        if($request->images){
        
            $this->savePhoto( $request, $produit->id);
        }
        
        
        return redirect()->back()->with('ok', 'Nouveau produit ajouté');
    }

    /**
     * Display the specified resource.
     */
    public function show($produit_id)
    {
        $produit = Produit::where('id', Crypt::decrypt($produit_id))->first();
    
        return view('produit.show', compact('produit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $produit_id)
    {   
        $produit = Produit::where('id', Crypt::decrypt($produit_id))->first();
        $categories = Categorieproduit::whereNull('parent_id')->get();
        
        $caracteristiques = Caracteristique::where('archive',false)->get();
        
        $categories = Categorieproduit::where([['parent_id', null], ['archive',false]])->get();
        $marques = Marque::where('archive', false)->get();
        
        return view('produit.edit', compact('categories', 'produit','marques','caracteristiques'));
 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $produit_id)
    {
        $produit = Produit::where('id', Crypt::decrypt($produit_id))->first();
           
        $produit->nom = $request->nom;
        $produit->description = $request->description;
        $produit->reference = $request->reference;
        $produit->marque_id = $request->marque;
        $produit->prix_vente_ht = $request->prix_vente_ht;
        $produit->prix_vente_ttc = $request->prix_vente_ttc;
        $produit->prix_vente_max_ht = $request->prix_vente_max_ht;
        $produit->prix_vente_max_ttc = $request->prix_vente_max_ttc;
        $produit->prix_achat_ht = $request->prix_achat_ht;
        $produit->prix_achat_ttc = $request->prix_achat_ttc;
        $produit->prix_achat_commerciaux_ht = $request->prix_achat_commerciaux_ht;
        $produit->prix_achat_commerciaux_ttc = $request->prix_achat_commerciaux_ttc;
        $produit->gerer_stock = $request->gerer_stock ? true : false;
        
        
        $produit->update();
        


        // stock
        if( $request->gerer_stock){        
        
            $stock = Stock::where('produit_id', $produit->id)->first();
            
            if($stock == null){
            
                $stock = Stock::create([
                    "produit_id" => $produit->id,
                    "quantite" => $request->quantite,
                    "quantite_min" => $request->quantite_min_vente,
                    "seuil_alerte" => $request->seuil_alerte_stock,
                   
                ]);
            
            }else{
                $stock->quantite = $request->quantite;
                $stock->quantite_min = $request->quantite_min_vente;
                $stock->seuil_alerte = $request->seuil_alerte_stock;
                $stock->update(); 
            }
                
                       
             
        }
        
        
        if($request->categories_id){
        
            $produit->categorieproduits()->detach();
            $produit->categorieproduits()->attach($request->categories_id);
        }
        
        
        
        if($request->hasFile('fiche_technique') ){
         
        //  Supprimer l'ancienne fiche technique
            // return response()->download(storage_path('app/pdf_compromis/pdf_compro.pdf'));
            $file_path = storage_path('app/public/fiche_technique/');
            
            $file_path .= $produit->fiche_technique;


     
            if (file_exists($file_path) && $produit->fiche_technique != null) {
                unlink($file_path);
            }
        
            $filename = 'fiche_technique_'.$produit->id.'.pdf';
            $produit->fiche_technique = $filename;
            // return response()->download(storage_path('app/pdf_compromis/pdf_compro.pdf'));
            $request->fiche_technique->storeAs('public/fiche_technique',$filename);
            $produit->update();
            
        }
        
        
        if($request->images){
        
            $this->savePhoto( $request, $produit->id);
        }
        
        
        return redirect()->back()->with('ok', 'Produit modifié');
        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
        //
    }
    
    
        ///////// ########## GESTION DES PHOTOS D'UN PRODUIT 


    /**
    * sauvegarde des images du produit 
    */
    public function savePhoto(Request $request, $produit_id){
    
        $images = $request->file('images');
         
        
        
        if (!is_array($images)) {
            $images = [$images];
        }
        // dd($this->images_path);
        
        if (!is_dir($this->images_path)) {
            File::makeDirectory($this->images_path, 0777);
            $this->images_path .= '/'.$produit_id;
            File::makeDirectory($this->images_path, 0777);
        }else{
            $this->images_path .= '/'.$produit_id;
            if (!is_dir($this->images_path)) {

                File::makeDirectory($this->images_path, 0777);
            }
        }

        
       
        for ($i = 0; $i < count($images); $i++) {
            $photo = $images[$i];
            $name = sha1(date('YmdHis') .Str::random(30));
            $save_name = $produit_id.'/'.$name. '.' .$photo->getClientOriginalExtension();
            $resize_name = $name. Str::random(2). '.' .$photo->getClientOriginalExtension();
            
            $img = Image::make($photo);

          
            $photo->move($this->images_path, $save_name);
            
            
            // dans ce bloc, on réccupère la plus grande position enrégistrée et on l'incremente pour la position de l'image suivante
            $image_position = 0;
            $image_position =  Imageproduit::where([
                ['produit_id',$produit_id]
                ])->pluck('position_image')->toArray();

            if(sizeof($image_position) ==0 ){
                $image_position = 1;
            }else{
                  $image_position = max($image_position ) + 1;
            }
          
            

            Imageproduit::create([
                "produit_id" => $produit_id,
                "nom_fichier" => $save_name,
                "nom_redimensionne" => $produit_id.'/'.$resize_name,
                "position_image" => $image_position,
                
            ]);
                 //dd($images);
        }
        return Response::json([
            'message' => 'Image sauvegardée'
        ], 200);
    }

    
    // Suppression d'une photo pendant l'upload
    public function destroyPhoto($image_id)
    {
  

        $uploaded_image = Imageproduit::where('id', $image_id)->first();
 
        if (empty($uploaded_image)) {
            return Response::json(['message' => 'desolé cette photo n\'existe pas'], 400);
        }
 
        $file_path = $this->images_path . '/' . $uploaded_image->nom_fichier;
        $resized_file = $this->images_path . '/' . $uploaded_image->nom_redimensionne;
 
        if (file_exists($file_path)) {
            unlink($file_path);
        }
 
        if (file_exists($resized_file)) {
            unlink($resized_file);
        }
 
        if (!empty($uploaded_image)) {
            $uploaded_image->delete();
        }
 
        return Response::json(['message' => 'Fiichier supprimé'], 200);
    }

    public function deletePhoto($id){

        $photo = Imageproduit::where('id', $id)->first();
        $photo->delete();
        return back()->with('ok', __("Photo supprimée"));
    }
    
    /** Fonction de téléchargement des images du produit 
    * @return \Illuminate\Http\Response
    **/ 
    public function getPhoto( $photo_id){
    
        $photo = Imageproduit::where('id', Crypt::decrypt($photo_id))->firstorfail();
    
        $path = public_path('images\images_produits\\'.$photo->nom_fichier) ;
        return response()->download($path);
    }
    
    
        
    /** Fonction de téléchargement des images du produit 
    * @return \Illuminate\Http\Response
    **/ 
    public function getFicheTechnique($nom_fichier){
    
        $path = storage_path('app\public\fiche_technique\\'.$nom_fichier) ;
        return response()->download($path);
    }
    
    
    
    /** Fonction de téléchargement des images du produit document
    * @return \Illuminate\Http\Response
    **/ 
    
    public function updatePhoto(Request $request){
    
        //    return $list_photo;
        $tab_list = json_decode($request["list"], true);
        $i = 0; 
        while($i < sizeof($tab_list)){
            $photo = Imageproduit::where('id',$tab_list[$i])->firstorfail();
            $photo->image_position = $i +1;
            $photo->update();
            $i++;
        }
    
        return Response::json([
            'message' => $tab_list
        ], 200);
    }
    
    
    
    
    
    // #### DECLINAISON DE PRODUIT
    
     /**
     * Création d'une déclinaison de  produit
     */
    public function store_declinaison(Request $request)
    {
    
        $produit = Produit::where('id', $request->produit_id)->first();
        
        
        $produitdecli = Produit::create([
            "nom" => $produit->nom,
            "produit_id" => $produit->id,
            "fournisseur_id" => $produit->fournisseur_id,
            "description" => $produit->description,
            "reference" => $produit->reference,
            "fiche_technique" => $produit->fiche_technique,
            "user_id" => Auth::user()->id,
            "marque_id" => $produit->marque,
            "prix_vente_ht" => $request->prix_vente_ht_decli,
            "type" => "declinaison",
            "prix_vente_ttc" => $request->prix_vente_ttc_decli,
            "prix_vente_max_ht" => $request->prix_vente_max_ht_decli,
            "prix_vente_max_ttc" => $request->prix_vente_max_ttc_decli,
            "prix_achat_ht" => $request->prix_achat_ht_decli,
            "prix_achat_ttc" => $request->prix_achat_ttc_decli,
            "prix_achat_commerciaux_ht" => $request->prix_achat_commerciaux_ht_decli,
            "prix_achat_commerciaux_ttc" => $request->prix_achat_commerciaux_ttc_decli,
            "gerer_stock" => $request->gerer_stock_decli ? true : false,     
        ]);
        
       
       // On réccupère les ids des valeurs des caractéristiques
        $valeurids = [];
        foreach ($request->all() as $key => $value) {
            if(str_contains($key, "valeurNom" ) ){
               $valeurids [] = $value;            
            }         
        }
        
        
        if(sizeof($valeurids) > 0 ){
            $produitdecli->valeurcaracteristiques()->attach($valeurids);
        }
        
        $produit->a_declinaison = true;
        $produit->update();
      
        // stock
        if( $request->gerer_stock_decli){
        
            $stock = Stock::create([
                "produit_id" => $produitdecli->id,
                "quantite" => $request->quantite_decli,
                "quantite_min" => $request->quantite_min_vente_decli,
                "seuil_alerte" => $request->seuil_alerte_stock_decli,
               
            ]);
            
        }
        
        return redirect()->back()->with('ok', 'Nouvelle déclinaison ajoutée');
    }
    
    
     /**
     * Modification d'une déclinaison de  produit
     */
    public function update_declinaison(Request $request, $produitdeli_id)
    {
    
        $produitdecli = Produit::where('id', Crypt::decrypt($produitdeli_id))->first();
        // dd($request->all());
        $produitdecli->prix_vente_ht = $request->prix_vente_ht_decli;
        $produitdecli->prix_vente_ttc = $request->prix_vente_ttc_decli;
        $produitdecli->prix_vente_max_ht = $request->prix_vente_max_ht_decli;
        $produitdecli->prix_vente_max_ttc = $request->prix_vente_max_ttc_decli;
        $produitdecli->prix_achat_ht = $request->prix_achat_ht_decli;
        $produitdecli->prix_achat_ttc = $request->prix_achat_ttc_decli;
        $produitdecli->prix_achat_commerciaux_ht = $request->prix_achat_commerciaux_ht_decli;
        $produitdecli->prix_achat_commerciaux_ttc = $request->prix_achat_commerciaux_ttc_decli;
        $produitdecli->gerer_stock = $request->gerer_stock_decli ? true : false;

       $produitdecli->update(); 
       
       // On réccupère les ids des valeurs des caractéristiques
        $valeurids = [];
        foreach ($request->all() as $key => $value) {
            if(str_contains($key, "valeurNom" ) ){
               $valeurids [] = $value;            
            }         
        }
        
        
        if(sizeof($valeurids) > 0 ){
            $produitdecli->valeurcaracteristiques()->detach();
            $produitdecli->valeurcaracteristiques()->attach($valeurids);
        }
        
      
        // stock
        if(isset($request->gerer_stock_decli)){        
      
            $stock = Stock::where('produit_id', $produitdecli->id)->first();
            
            if($stock == null){
            
                $stock = Stock::create([
                    "produit_id" => $produitdecli->id,
                    "quantite" => $request->quantite_decli,
                    "quantite_min" => $request->quantite_min_vente_decli,
                    "seuil_alerte" => $request->seuil_alerte_stock_decli,
                   
                ]);
            
            }else{
                $stock->quantite = $request->quantite_decli;
                $stock->quantite_min = $request->quantite_min_vente_decli;
                $stock->seuil_alerte = $request->seuil_alerte_stock_decli;
                $stock->update(); 
            }
                
                       
             
        }
   
        return redirect()->back()->with('ok', 'Déclinaison modifiée');
    }
}
