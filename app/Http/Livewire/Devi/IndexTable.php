<?php

namespace App\Http\Livewire\Devi;

use App\Models\Contact;
use App\Models\Devi;
use Crypt;
use Auth;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};
use Illuminate\Support\Facades\Gate;

final class IndexTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;
    public $devis;
    public $categories_id = [];
    
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
    
      
            $devis = Devi::where([['archive', false],['type','simple']])->get();
            
        
        return $devis;

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
            ->addColumn('type', function (Devi $model) {
       
                return  '<button type="button" class="btn btn-light btn-sm rounded-pill">'.$model->numero_devis.'</button>';
            } )
            
            ->addColumn('nom')
            ->addColumn('statut', function (Devi $model) {
                if($model->statut == "accepté"){
                    $color = "btn-success ";
                }
                elseif($model->statut == "refusé"){
                    $color = "btn-danger ";                
                }else{
                    $color = "btn-warning ";
                }
                
                return  '<button type="button" class="btn '.$color.' btn-sm rounded-pill">'.$model->statut.'</button>';
                
            } )
            ->addColumn('montant_ht')
            ->addColumn('montant_ttc')
            ->addColumn('remise')
            ->addColumn('client_prospect', function (Devi $model) {
                if($model->client_prospect){
                    return  $model->client_prospect->nom;
                }
                return "non renseigné";
            } )
            ->addColumn('collaborateur', function (Devi $model) {
                if($model->collaborateur){
                    return  $model->collaborateur->nom;
                }
                return "non renseigné";
            } )
            ->addColumn('date_devis', function (Devi $model) {
                return  $model->date_devis->format('d/m/Y');
            } )
            ->addColumn('duree_validite', function (Devi $model) {
                return  $model->duree_validite." jours";
            } );
      
            
           
         
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
            Column::make('Numéro devis', 'numero')->sortable()->searchable(), 
            Column::make('Nom', 'nom')->sortable()->searchable(),
            Column::make('Statut', 'Statut')->sortable()->searchable(),
            Column::make('Montant ht', 'montant_ht')->sortable()->searchable(),
            Column::make('Montant ttc', 'montant_ttc')->sortable()->searchable(),
            Column::make('Remise', 'remise')->sortable()->searchable(),
            Column::make('Client/Prospect', 'client_prospect')->sortable()->searchable(),
            Column::make('Créé par', 'collaborateur')->sortable()->searchable(),
            Column::make('Date', 'date_devis')->sortable()->searchable(),
            Column::make('Durée validité', 'duree_validite')->sortable()->searchable(),


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
                ->bladeComponent('button-show', function(Devi $devi) {
                    return ['route' => route('devi.show', Crypt::encrypt($devi->id)),
                    'tooltip' => "Afficher",
                    'permission' => Gate::allows('permission', 'afficher-devi'),                    
                    ];
                }),
                
            Button::add('Modifier')
            ->bladeComponent('button-edit', function(Devi $devi) {
                return ['route' => route('devi.edit', Crypt::encrypt($devi->id)),
                'tooltip' => "Modifier",
                'permission' => Gate::allows('permission', 'modifier-devi'),                
                ];
            }),
            
            Button::add('Archiver')
            ->bladeComponent('button-archive', function(Devi $devi) {
                return ['route' => route('devi.archive', Crypt::encrypt($devi->id)),
                'tooltip' => "Archiver",
                'classarchive' => "archive_devi",
                'permission' => Gate::allows('permission', 'archiver-devi'),
                
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
