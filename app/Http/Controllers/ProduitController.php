<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Imageproduit;
use App\Models\Stock;
use App\Models\Marque;
use App\Models\Categorieproduit;
use App\Models\Caracteristique;
use App\Models\Valeurcaracteristique;
use App\Models\Tva;
use App\Models\Voiture;
use App\Models\Circuit;
use App\Models\Modelevoiture;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Database\Query\JoinClause;

class ProduitController extends Controller
{

    private $images_path;

    public function __construct()
    {
       $this->images_path = public_path('/images/images_produits');
    }
    
    
    /**
     * Page d'accueil du module produit
     */
    public function index()
    {
      
        $categories = Categorieproduit::where([['parent_id', null], ['archive',false]])->get();
        return view('produit.index',compact('categories'));

    }

    /**
     * Page d'ajout d'un produit
     */
    public function create()
    {
    
        $categories = Categorieproduit::where([['parent_id', null], ['archive',false]])->get();
        $marques = Marque::where('archive', false)->get();
        
        $tvas = Tva::where('archive', false)->get();
        $tva_principale = Tva::where('est_principal', true)->first();
        $valeur_tva = $tva_principale->taux;
        $caracteristiques = Caracteristique::where('archive',false)->get();
        $modelevoitures = Modelevoiture::all();
        $circuits = Circuit::where('archive',false)->get();
        
        return view('produit.add', compact('categories','marques', 'tvas','tva_principale','valeur_tva','caracteristiques','modelevoitures','circuits'));
        
    }

    /**
     * Création d'un produit
     */
    public function store(Request $request)
    {
        
 
        try{
            
            DB::beginTransaction();

            if($request->type == "declinaison"){
                
                $produit = Produit::create([
                    "nom" => $request->nom,
                    "type" => "simple",
                    "a_declinaison" => true,
                    "nature" => $request->nature,
                    "description" => $request->description,
                    "reference" => $request->reference,
                    "user_id" => Auth::user()->id,
                    "marque_id" => $request->marque,              
                    "tva_id" => $request->tva_id,             
                ]);
                
            
                $this->generer_declinaison($request, $produit->id);
                
                
            }
            
            else{
            
                $produit = Produit::create([
                    "nom" => $request->nom,
                    "type" => "simple",
                    "nature" => $request->nature,
                    "description" => $request->description,
                    "reference" => $request->reference,
                    "user_id" => Auth::user()->id,
                    "marque_id" => $request->marque,
                    "prix_vente_ht" => $request->prix_vente_ht,
                    "prix_vente_ttc" => $request->prix_vente_ttc,
                    "tva_id" => $request->tva_id,
                    "prix_achat_ht" => $request->prix_achat_ht,
                    "prix_achat_ttc" => $request->prix_achat_ttc,
                    "gerer_stock" => $request->gerer_stock ? true : false,
                
                ]);
                
                // stock
                if( $request->gerer_stock){
                
                    $stock = Stock::create([
                        "produit_id" => $produit->id,
                        "quantite" => $request->quantite,
                        "quantite_min" => $request->quantite_min_vente,
                        "seuil_alerte" => $request->seuil_alerte_stock,
                    
                    ]);
                    
                }
            }
            
            
            if($request->categories_id){
                $produit->categorieproduits()->attach($request->categories_id);
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
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout du produit');
        }
        
        return redirect()->route('produit.index')->with('ok', 'Nouveau produit ajouté');
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
        $tvas = Tva::where('archive', false)->get();
        $tva_principale = Tva::where('est_principal', true)->first();
        $valeur_tva = $tva_principale->taux;
        $modelevoitures = Modelevoiture::all();
        $circuits = Circuit::where('archive',false)->get();
        
        return view('produit.edit', compact('categories', 'produit','marques','caracteristiques','tvas','tva_principale','valeur_tva','modelevoitures','circuits'));
 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $produit_id)
    {
        $produit = Produit::where('id', Crypt::decrypt($produit_id))->first(); 


        $produit->nom = $request->nom;
        $produit->description = $request->description;
        $produit->nature = $request->nature;
        $produit->reference = $request->reference;
        $produit->marque_id = $request->marque;
        $produit->prix_vente_ht = $request->prix_vente_ht;
        $produit->prix_vente_ttc = $request->prix_vente_ttc;
        $produit->tva_id = $request->tva_id;
        
        // $produit->prix_vente_max_ht = $request->prix_vente_max_ht;
        // $produit->prix_vente_max_ttc = $request->prix_vente_max_ttc;
        $produit->prix_achat_ht = $request->prix_achat_ht;
        $produit->prix_achat_ttc = $request->prix_achat_ttc;
        // $produit->prix_achat_commerciaux_ht = $request->prix_achat_commerciaux_ht;
        // $produit->prix_achat_commerciaux_ttc = $request->prix_achat_commerciaux_ttc;
        $produit->gerer_stock = $request->gerer_stock ? true : false;
        
        
        $produit->update();
        
        
        // MAJ des déclinaisons
        
        $retour = $this->update_all_declinaison($request);


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
    * Génération des déclinaisons d'un produit
    */
    public function generer_declinaison(Request $request, $produit_id){
     
        try{
            DB::beginTransaction();
            $produit_parent = Produit::where('id', $produit_id)->first();
            
                $valeurids = [];
                foreach ($request->all() as $key => $value) {
                    if(str_contains($key, "valeurNom" ) ){                    
                        array_push($valeurids, $value);
                        
                    }         
                }
                
                $combinaisons =  $this->genererCombinaisons($valeurids);          
        
                $modelevoitures = $request->modelevoitures;
                $circuits = $request->circuits;
                
                $combinaison_voiture_circuit = [];
                
                foreach ($circuits as $circuit_id) {
                    
                    $circuit = Circuit::where('id', $circuit_id)->first();
                    
                    foreach ($modelevoitures as $modelevoiture_id) {
                        $modelevoitureModel = Modelevoiture::where('id', $modelevoiture_id)->first();
                        
                        $nom_produit_temp = $produit_parent->nom.'-'.$modelevoitureModel->nom.'-'.$circuit->nom;
                        $prix_produit_temp =  $modelevoitureModel->prix_vente_kilometrique * $circuit->distance;
                    
                        $combinaison_voiture_circuit[] = [
                            "nom_produit" => $nom_produit_temp,
                            "prix_produit" => $prix_produit_temp,
                            "modelevoiture_id" => $modelevoiture_id,
                            "circuit_id" => $circuit_id,
                        ];
                    }
                    
                }
                
            
                foreach ($combinaisons as $combinaison) {
                    
                    $nomcaracteristique = $this->generer_nom_caracteristique($combinaison);
                 
                    foreach ($combinaison_voiture_circuit as $combi_v_c) {
                    
                        //   On reccupère les valeurs des caractéristiques avec lequels on va calculer le prix du produit
                        $total_valeur_multiplier = 0;
                        $total_valeur_additionner = 0;
                        foreach ($combinaison as $combi) {
                         
                            $valeurcaract = Valeurcaracteristique::where('id', $combi)->first();
                            $caracteristique = $valeurcaract->caracteristique;
                            if($caracteristique?->calcul_prix_produit){
                              
                                if($caracteristique->calcul_prix_produit_type == "multiplier"){
                                    $total_valeur_multiplier += $valeurcaract->valeur;
                                }elseif($caracteristique->calcul_prix_produit_type == "additionner"){
                                    $total_valeur_additionner += $valeurcaract->valeur;
                                }
                            }
                        }
                    

                        // $cartacteristique 
                        $nom_produit_temp = $combi_v_c["nom_produit"]." / $nomcaracteristique";
                        $prix_produit_temp = $combi_v_c["prix_produit"];
                        $modelevoiture_id = $combi_v_c["modelevoiture_id"];
                        $circuit_id = $combi_v_c["circuit_id"];
                        
                        $prix_declinaison_ttc = round($prix_produit_temp * $total_valeur_multiplier + $total_valeur_additionner,2);
                        $prix_declinaison_ht = round($prix_declinaison_ttc / (1 + ($produit_parent->tva->taux / 100)),2);
                    
                        $produit_decli = Produit::create([
                        
                            "nom" => $nom_produit_temp,
                            "type" => "declinaison",
                            "produit_id" => $produit_parent->id,
                            "nature" => $produit_parent->nature,
                            "description" => $produit_parent->description,
                            "reference" => $produit_parent->reference,
                            "user_id" => Auth::user()->id,
                            "marque_id" => $produit_parent->marque,
                            "modelevoiture_id" => $modelevoiture_id,
                            "circuit_id" => $circuit_id,
                            "prix_vente_ht" => $prix_declinaison_ht,
                            "prix_vente_ttc" => $prix_declinaison_ttc,
                            "tva_id" => $produit_parent->tva_id,
                        
                        ]);

                        $produit_decli->valeurcaracteristiques()->attach($combinaison, ['modelevoiture_id' => $modelevoiture_id, 'circuit_id' => $circuit_id]);
                        if($request->categories_id){
                            $produit_decli->categorieproduits()->attach($request->categories_id);
                        }
                    }
                }
                DB::commit();
                return true;
                
            }catch(\Exception $e){
                DB::rollBack();
                return redirect()->back()->with('error', 'Erreur lors de la génération des déclinaisons');
            }
          
        }
    
    
    /**
     * Fonction de création des combinaisons
     */
    function genererCombinaisons($GAB) {
    
        $combinations = [[]];
     
        foreach ($GAB as $tab) {
            $temp = [];
            foreach ($combinations as $combination) {
                $temp[] = $combination;
                
                foreach ($tab as $value) {
                    $temp[] = array_merge($combination, [$value]);
                }
            }
            
            $combinations = $temp;
           
        }
      
        // $combinations = array_filter($combinations, function($value) { return $value !== []; });
        $combinaisons = array_shift($combinations);
        return $combinations;
        
    }
    
    
    /**
     * Fonction de génération de nom par les caracteristiques
     */
    function generer_nom_caracteristique($combinaison){
    
        $nomcaracteristique = "";
        foreach ($combinaison as  $combi) {
            $valeurcaract = Valeurcaracteristique::where('id', $combi)->first();
            if(sizeof($combinaison) > 1){
                $nomcaracteristique .= $valeurcaract->caracteristique->nom." : ".$valeurcaract->nom." / ";
            }else{
                $nomcaracteristique .= $valeurcaract->caracteristique->nom." : ".$valeurcaract->nom;
            }
            
        }
        return $nomcaracteristique;
    }
    
    /**
     * Fonction pour générer le nom d'une déclinaison
     */
    function generer_nom_declinaison(Request $request, $produit_parent){
        
        // Récupérer les valeurs des caractéristiques
        $valeurids = [];
        foreach ($request->all() as $key => $value) {
            if(str_contains($key, "valeurNom" ) && $value != null ){
                $valeurids [] = $value;            
            }         
        }
        
        // Générer le nom des caractéristiques
        $nomcaracteristique = "";
        if(sizeof($valeurids) > 0 ){
            $nomcaracteristique = $this->generer_nom_caracteristique($valeurids);
        }
        
        // Récupérer le modèle de voiture
        $nom_modele = "";
        if($request->modelevoiture_id){
            $modelevoiture = Modelevoiture::where('id', $request->modelevoiture_id)->first();
            if($modelevoiture){
                $nom_modele = $modelevoiture->nom;
            }
        }
        
        // Récupérer le circuit
        $nom_circuit = "";
        if($request->circuit_id){
            $circuit = Circuit::where('id', $request->circuit_id)->first();
            if($circuit){
                $nom_circuit = $circuit->nom;
            }
        }
        
        // Construire le nom final
        $nom_final = $produit_parent->nom;
        
        if($nom_modele){
            $nom_final .= '-'.$nom_modele;
        }
        
        if($nom_circuit){
            $nom_final .= '-'.$nom_circuit;
        }
        
        if($nomcaracteristique){
            $nom_final .= ' / '.$nomcaracteristique;
        }
        
        return $nom_final;
    }
    
    
    
    
    
    
    
    
    
    
     /**
     * Création d'une déclinaison unique pour le  produit
     */
    public function store_declinaison(Request $request)
    {
        try{
            DB::beginTransaction();
        
            $produit = Produit::where('id', $request->produit_id)->first();
            
            // Générer le nom de la déclinaison automatiquement
            $nom_declinaison = $this->generer_nom_declinaison($request, $produit);

           

            // vérifier si la déclinaison existe déjà
            $produitdecli = Produit::where('nom', $nom_declinaison)->first();
            if($produitdecli){
                return redirect()->back()->with('error', 'La déclinaison existe déjà');
            }

            $produitdecli = Produit::create([
                "nom" => $nom_declinaison,
                "produit_id" => $produit->id,
                "modelevoiture_id" => $request->modelevoiture_id,
                "circuit_id" => $request->circuit_id,
                "fournisseur_id" => $produit->fournisseur_id,
                "description" => $produit->description,
                "reference" => $produit->reference,
                "fiche_technique" => $produit->fiche_technique,
                "user_id" => Auth::user()->id,
                "prix_vente_ht" => $request->prix_vente_ht_decli,
                "type" => "declinaison",
                "prix_vente_ttc" => $request->prix_vente_ttc_decli,
                "prix_achat_ht" => $request->prix_achat_ht_decli,
                "prix_achat_ttc" => $request->prix_achat_ttc_decli,
                "gerer_stock" => $request->gerer_stock_decli ? true : false,     
            ]);
            
        
        // On réccupère les ids des valeurs des caractéristiques
            $valeurids = [];
            foreach ($request->all() as $key => $value) {
                if(str_contains($key, "valeurNom" ) && $value != null ){
                $valeurids [] = $value;            
                }         
            }
            
            
            if(sizeof($valeurids) > 0 ){
                $produitdecli->valeurcaracteristiques()->attach($valeurids, [
                    'modelevoiture_id' => $request->modelevoiture_id,
                    'circuit_id' => $request->circuit_id
                ]);
            }
            
            $produit->a_declinaison = true;
            $produit->update();
            // $this->generer_declinaison($request, $produit->id);
        
            // stock
            if( $request->gerer_stock_decli){
            
                $stock = Stock::create([
                    "produit_id" => $produitdecli->id,
                    "quantite" => $request->quantite_decli,
                    "quantite_min" => $request->quantite_min_vente_decli,
                    "seuil_alerte" => $request->seuil_alerte_stock_decli,
                
                ]);
                
            }
            
            DB::commit();
            return redirect()->back()->with('message', 'Nouvelle déclinaison ajoutée');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la création de la déclinaison');
        }
    }
    
    
     /**
     * Modification d'une déclinaison de  produit
     */
    public function update_declinaison(Request $request, $produitdeli_id)
    {
    
        $produitdecli = Produit::where('id', Crypt::decrypt($produitdeli_id))->first();
        $produit_parent = Produit::where('id', $produitdecli->produit_id)->first();
        
        // Générer le nom de la déclinaison automatiquement
        $nom_declinaison = $this->generer_nom_declinaison($request, $produit_parent);
        
        // dd($request->all());
        $produitdecli->nom = $nom_declinaison;
        $produitdecli->prix_vente_ht = $request->prix_vente_ht_decli;
        $produitdecli->prix_vente_ttc = $request->prix_vente_ttc_decli;
        // $produitdecli->prix_vente_max_ht = $request->prix_vente_max_ht_decli;
        // $produitdecli->prix_vente_max_ttc = $request->prix_vente_max_ttc_decli;
        $produitdecli->prix_achat_ht = $request->prix_achat_ht_decli;
        $produitdecli->prix_achat_ttc = $request->prix_achat_ttc_decli;
        // $produitdecli->prix_achat_commerciaux_ht = $request->prix_achat_commerciaux_ht_decli;
        // $produitdecli->prix_achat_commerciaux_ttc = $request->prix_achat_commerciaux_ttc_decli;
        $produitdecli->gerer_stock = $request->gerer_stock_decli ? true : false;
        $produitdecli->modelevoiture_id = $request->modelevoiture_id;
        $produitdecli->circuit_id = $request->circuit_id;

       $produitdecli->update(); 

       // On réccupère les ids des valeurs des caractéristiques
        $valeurids = [];
        foreach ($request->all() as $key => $value) {
            if(str_contains($key, "valeurNom" ) && $value != null ){
               $valeurids [] = $value;            
            }         
        }
        
        
        if(sizeof($valeurids) > 0 ){
            $produitdecli->valeurcaracteristiques()->detach();
            $produitdecli->valeurcaracteristiques()->attach($valeurids, [
                'modelevoiture_id' => $request->modelevoiture_id,
                'circuit_id' => $request->circuit_id
            ]);
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
    
    
    /**
    * Modifier toutes les declinations d'un produit
    */
    public function update_all_declinaison(Request $request){
        
       
        $params = array_filter($request->all(), function($key){
            return (str_contains($key,"nom_" ) || str_contains($key,"prixventeht_" ) || str_contains($key,"prixventettc_" ) || str_contains($key,"id_" )  );
            },
            ARRAY_FILTER_USE_KEY
        );
        
       
        $tab_produits = array_chunk($params, 4);
        
        // dd($tab_produits);
        
        foreach ($tab_produits as $key => $prod) {
            
            // prod[0] = nom, prod[1] = prix_ht, prod[2] =  prix_ttc, prod[3] = id
            $produitdecli = Produit::where('id', $prod[3])->first();
            
            $produitdecli->nom = $prod[0];
            $produitdecli->prix_vente_ht = $prod[1];
            $produitdecli->prix_vente_ttc = $prod[2];
            $produitdecli->update();
            
            if($request->categories_id){
        
                $produitdecli->categorieproduits()->detach();
                $produitdecli->categorieproduits()->attach($request->categories_id);
            }
            
        }
        
        return redirect()->back()->with('ok', 'Les déclinaisons ont été modifiées');
    }

    /**
    * Recaluler les prix des déclinaisons du produit
    */
    public function recalculer_declinaisons($produit_parent_id){
    
    
        $produitparent = Produit::where('id', Crypt::decrypt($produit_parent_id))->first();
        
        $produitdeclis = Produit::where('produit_id', $produitparent->id)->get();



        foreach ($produitdeclis as $produitdecli) {
            
      
            $prix_declinaison_ttc = 0;
            foreach($produitdecli->valeurcaracteristiques as $valcarac){
                if($valcarac->calcul_prix_produit){
                    
                    $prix_declinaison_ttc += $valcarac->valeur * $produitdecli->modelevoiture->prix_vente_kilometrique * $produitdecli->circuit->distance ;
                    // $prix_declinaison_ttc += $prix_declinaison_ht * (1 + ($produitdecli->tva->taux / 100));
                }
                  
            }
            
            $produitdecli->prix_vente_ttc = round($prix_declinaison_ttc,2); $prix_declinaison_ttc;
            $produitdecli->prix_vente_ht = round($prix_declinaison_ttc / (1 + ($produitdecli->tva->taux / 100)),2);
            $produitdecli->save();
        }
        
        return redirect()->back()->with('ok', 'Les prix des déclinaisons ont été recalculées');
    }


    /**
     * Listes des produits archivés
    */
    public function archives()
    {
       
        $categories = Categorieproduit::where([['parent_id', null], ['archive',false]])->get();
        return view('produit.archive',compact('categories'));
      
    }
    
    /**
     * Archiver un produit
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archiver($produit_id)
    {
        $produit = Produit::where('id', Crypt::decrypt($produit_id))->first();

        $produit->archive = true;
        $produit->update();
        
        return "200";
    }
    
    /**
     * Désarchiver un produit
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function desarchiver($produit_id)
    {
        $produit = Produit::where('id', Crypt::decrypt($produit_id))->first();
        
        
        $produit->archive = false;
        $produit->update();
        
        return "200";
    }
    
    /**
    * Rechercher des produits 
    */
    public function rechercher_produit(Request $request){
        
        // {categorie_id: '4', voiture_id: '1', circuit_id: null}
        $produits = DB::table('produits')
                    ->where(function($query) use ($request){
                        // if($request->categorie_id != null){
                        //     $query->where('categorieproduit_id', $request->categorie_id);
                        // }
                        if($request->voiture_id != null){
                            $query->where('voiture_id', $request->voiture_id);
                        }
                        if($request->circuit_id != null){
                            $query->where('circuit_id', $request->circuit_id);
                        }
                    })
                    ->join('categorieproduit_produit', function(JoinClause $join) use ($request){
                    
                        $join->on('produits.id', '=', 'categorieproduit_produit.produit_id');
                        if($request->categorie_id != null){
                            $join->where('categorieproduit_produit.categorieproduit_id', '=', $request->categorie_id);
                        }
                    })
                    
                    // ->join('categorieproduits', 'categoriesproduit_produits.categorieproduit_id', '=', 'categorieproduits.id')
                    ->select('produits.*','categorieproduit_produit.categorieproduit_id')
                    ->get();
                    
                    
        return $produits;
    }
}
