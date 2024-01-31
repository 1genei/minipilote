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

final class ArchiveTable extends PowerGridComponent
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
    
      
            $devis = Devi::where('archive', true)->get();
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
       
                $url_pdf = route('devis.telecharger', Crypt::encrypt($model->id));
                return  '<a href='.$url_pdf.' type="button" class="btn btn-info btn-sm rounded-pill">'.$model->numero_devis.'<i class="mdi mdi-download"></i> </a>';
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
            ->addColumn('net_a_payer', function (Devi $model) {
                return "<span class='text-info fw-bold'>".$model->net_a_payer."</span>";
            } )
            ->addColumn('client_prospect', function (Devi $model) {
                if($model->client_prospect()->type == "individu"){
                    return  $model->client_prospect()?->infos()?->nom." ".$model->client_prospect()?->infos()?->prenom;
                }else{
                    return $model->client_prospect()?->infos()?->raison_sociale;
                }
              
            } )
            ->addColumn('collaborateur', function (Devi $model) {
             
                return  $model->collaborateur()?->infos()?->nom." ".$model->collaborateur()?->infos()?->prenom;               
            } )
            
            ->addColumn('statut', function (Devi $model) {
                if($model->statut == "accepté"){
                    $color = "btn-success ";
                    return  '<button type="button" class="btn '.$color.' btn-sm rounded-pill">'.$model->statut.'</button>';
                    
                }
                elseif($model->statut == "refusé"){
                    $color = "btn-danger ";   
                    return  '<button type="button" class="btn '.$color.' btn-sm rounded-pill">'.$model->statut.'</button>';
                    
                }else{
                   
                   return   "<a data-href='".route('devis.updateStatut', [$model->id, 'accepté'])."' style='cursor: pointer;' class='action-icon text-success accepter_devis' data-bs-container='#tooltip-archive'
                            data-bs-toggle='tooltip' data-bs-placement='top' title='Accepter'><i class='mdi mdi-check'></i></a>".''.
                            
                            "<a data-href='".route('devis.updateStatut', [$model->id, 'refusé'])."' style='cursor: pointer;' class='action-icon text-danger refuser_devis ' data-bs-container='#tooltip-archive' data-bs-toggle='tooltip' data-bs-placement='top'
                            title='Refuser'><i class='mdi mdi-window-close'></i></a>  ";
                }
                
                
            } )
            ->addColumn('date_devis', function (Devi $model) {
                return  $model->date_devis;
            } );
            // ->addColumn('duree_validite', function (Devi $model) {
            //     return  $model->duree_validite." jours";
            // } );
      
            
           
         
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
            Column::make('Numéro devis', 'numero_devis')->sortable()->searchable(), 
            Column::make('Nom', 'nom_devis')->sortable()->searchable(),
            Column::make('Montant ht', 'montant_ht')->sortable()->searchable(),
            Column::make('Montant ttc', 'montant_ttc')->sortable()->searchable(),
            Column::make('Remise', 'montant_remise_total')->sortable()->searchable(),
            Column::make('Net à payer', 'net_a_payer')->sortable()->searchable(),
            Column::make('Client/Prospect', 'client_prospect')->sortable()->searchable(),
            Column::make('Créé par', 'collaborateur')->sortable()->searchable(),
            Column::make('Statut', 'statut')->sortable()->searchable(),
            Column::make('Crée le', 'date_devis')->sortable()->searchable(),
            // Column::make('Durée validité', 'duree_validite')->sortable()->searchable(),


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
                    return ['route' => route('devis.show', Crypt::encrypt($devi->id)),
                    'tooltip' => "Afficher",
                    'permission' => Gate::allows('permission', 'afficher-devis'),                    
                    ];
                }),
                
            Button::add('Modifier')
            ->bladeComponent('button-edit', function(Devi $devi) {
                return ['route' => route('devis.edit', Crypt::encrypt($devi->id)),
                'tooltip' => "Modifier",
                'permission' => Gate::allows('permission', 'modifier-devis'),                
                ];
            }),
            
            Button::add('Desarchiver')
            ->bladeComponent('button-unarchive', function(Devi $devi) {
                return ['route' => route('devis.desarchiver', Crypt::encrypt($devi->id)),
                'tooltip' => "Désarchiver",
                'classunarchive' => "unarchive_devis",
                'permission' => Gate::allows('permission', 'archiver-devis'),
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
