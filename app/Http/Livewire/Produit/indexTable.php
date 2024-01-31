<?php

namespace App\Http\Livewire\Produit;


use App\Models\Contact;
use App\Models\Produit;
use Crypt;
use Auth;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};
use Illuminate\Support\Facades\Gate;

final class indexTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;
    public $produits;
    public $categories_id = [];
    public string $sortField = 'id';    
    public string $sortDirection = 'desc';
    
    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        // $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()
            ->showSearchInput()
            ->showToggleColumns(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder<\App\Models\Contact>
     */
    public function datasource()
    {
    
        $user = Auth::user();

        if ($user->is_admin) {


            $produits = Produit::where([['archive', false],['type','simple']])->get();
            // On réccupère tous les contacts de type individu
                
            // $produits = Produit::select('produits.*','categorieproduits.nom')
            //     ->join('categorieproduit_produit', 'categorieproduit_produit.produit_id', '=', 'produits.id')
            //     ->join('categorieproduits', 'categorieproduit_produit.categorieproduit_id', '=', 'categorieproduits.id')
            //     ->where([['produits.archive', false],['produits.type','simple']])
            //     ->get();
       

        } else {
        
            $produits = Produit::where([['archive', false],['type','simple'], ['user_id',$user->id]])->get();
            
            //   On réccupère uniquement les contacts de l'utilisateur connecté
            
            // $produits = Produit::select('produits.*','categorieproduits.nom')
            //     ->join('categorieproduit_produit', 'categorieproduit_produit.produit_id', '=', 'produits.id')
            //     ->join('categorieproduits', 'categorieproduit_produit.categorieproduit_id', '=', 'categorieproduits.id')
            //     ->where([['produits.archive', false],['produits.type','simple'],['produits.user_id',$user->id]])
            //     // ->whereIn('categorieproduit_produit.categorie_id', $this->categories_id )
            //     ->get();
         
                
        }
    // dd($produits);
       
        
        return $produits;

    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
    
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridColumns
    {
    
        return PowerGrid::columns()
            // ->addColumn('id')
            ->addColumn('type', function (Produit $model) {
                if($model->type == "simple"){
                    $color = "btn-secondary ";
                }
                else{
                    $color = "btn-light ";                
                }
                return  '<button type="button" class="btn '.$color.' btn-sm rounded-pill">'.$model->type.'</button>';
            } )
            ->addColumn('nom')
            
            ->addColumn('nature')
            
            ->addColumn('image', function (Produit $model) {
                if($model->imageproduits != null && sizeof($model->imageproduits)>0 ){
                    $src = asset('/images/images_produits/' . $model->imageproduits[0]?->nom_fichier) ;
                    
                    return  ' <img src="'.$src.'" class="img-fluid" style="max-width: 80px; min-width: 80px;" alt="Photo du produit" />';
                
                }else{
                    return  '<span class="btn btn-sm rounded-pill"> sans image</span>';
                    
                }
            } )
            ->addColumn('reference')
            ->addColumn('categorie',function (Produit $model){
                
               
                $cats = "";
                foreach ($model->categorieproduits as $cat) {
                
               
                    $cats .= $cat->nom .", " ;
    
                }
                
                return $cats;
            } )
            ->addColumn('prix_vente_ht',function (Produit $model){
                
              
                return $model->prix_vente_ht;
            })
            ->addColumn('stock',function (Produit $model){
                
                if($model->stock){
                    return $model->stock->quantite;
                }
                return "non géré";
            });
         
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

     /**
      * PowerGrid Columns.
      *
      * @return array<int, Column>
      */
    public function columns(): array
    {
        return [
            // Column::make('Id', 'id'),
            Column::make('Type', 'type')->sortable()->searchable(), 
            Column::make('Nom', 'nom')->sortable()->searchable(),
            Column::make('Nature', 'nature')->sortable()->searchable(),
            Column::make('Image', 'image')->sortable()->searchable(),
            Column::make('Référence', 'reference')->sortable()->searchable(),
            Column::make('Catégories', 'categorie')->sortable()->searchable(),
            Column::make('Prix de vente HT', 'prix_vente_ht')->sortable()->searchable(),
            Column::make('Stock', 'stock')->sortable()->searchable(),


        ];
    }

    /**
     * PowerGrid Filters.
     *
     * @return array<int, Filter>
     */
    public function filters(): array
    {
    
        return [
            // Filter::datetimepicker('created_at'),
            // Filter::datetimepicker('nom'),
            // Filter::inputText('nom')->operators(['contains']),
            // Filter::inputText('prenom')->operators(['contains']),
            // Filter::inputText('email')->operators(['contains']),
            // Filter::inputText('telephone')->operators(['contains']),
            // Filter::inputText('adresse')->operators(['contains']),
            // Filter::inputText('code_postal')->operators(['contains']),
            // Filter::inputText('ville')->operators(['contains']),
            // Filter::inputText('pays')->operators(['contains']),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid Contact Action Buttons.
     *
     * @return array<int, Button>
     */

    
    public function actions(): array
    {
       return [
        //    Button::make('edit', 'Edit')
        //        ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
        //        ->route('prospect.create', function(\App\Models\Individu $model) {
        //             return $model->id;
        //        }),

               
               
            Button::add('Afficher')
                ->bladeComponent('button-show', function(Produit $produit) {
                    return ['route' => route('produit.show', Crypt::encrypt($produit->id)),
                    'tooltip' => "Afficher",
                    'permission' => Gate::allows('permission', 'afficher-produit'),                    
                    ];
                }),
                
            Button::add('Modifier')
            ->bladeComponent('button-edit', function(Produit $produit) {
                return ['route' => route('produit.edit', Crypt::encrypt($produit->id)),
                'tooltip' => "Modifier",
                'permission' => Gate::allows('permission', 'modifier-produit'),                
                ];
            }),
            
            Button::add('Archiver')
            ->bladeComponent('button-archive', function(Produit $produit) {
                return ['route' => route('produit.archive', Crypt::encrypt($produit->id)),
                'tooltip' => "Archiver",
                'classarchive' => "archive_produit",
                'permission' => Gate::allows('permission', 'archiver-produit'),
                
                ];
            }),
        ];
    }
    

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Contact Action Rules.
     *
     * @return array<int, RuleActions>
     */

   
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($contact) => $contact->id === 1)
                ->hide(),
        ];
    }
}
