<?php

namespace App\Http\Livewire\Prestation;


use App\Models\Contact;
use App\Models\Individu;
use App\Models\EntiteIndividu;
use App\Models\Prestation;
use Crypt;
use Auth;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};
use Illuminate\Support\Facades\Gate;

final class PrestationTable extends PowerGridComponent
{
    use ActionButton;
    use ActionButton;
    use WithExport;
    public $client_id;
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
      
        $prestations = Prestation::where([['archive', false], ['client_id', $this->client_id]])->get();

        return $prestations;

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
      
            ->addColumn('numero')
            ->addColumn('nom')
            ->addColumn('montant_ttc')
            ->addColumn('beneficiaire', function (Prestation $model) {          
                return  '<span >'.$model->beneficiaire()?->individu?->civilite.' '.$model->beneficiaire()?->individu?->nom.' '.$model->beneficiaire()?->individu?->prenom.'</span>';
            } )
            ->addColumn('notes')
            ->addColumn('date_prestation', function (Prestation $model){
                
               return Carbon::parse($model->date_prestation); 
            }  );
            
            // ->addColumn('user', function (Prestation $model) {          
            //     return  '<span >'.$model->user?->contact?->individu?->nom.' '.$model->user?->contact?->individu?->prenom.'</span>';
            // });
            // ->addColumn('statut');
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
            Column::make('Numero', 'numero')
                ->searchable()
                ->sortable(),
            Column::make('Nom', 'nom')->searchable()->sortable(),
            Column::make('Montant', 'montant_ttc')->searchable()->sortable(),
            Column::make('Beneficiaire', 'beneficiaire')->searchable()->sortable(),
            Column::make('Notes', 'notes')->searchable()->sortable(),
            Column::make('Date', 'date_prestation')->searchable()->sortable(),         
            // Column::make('Statut', 'statut')->searchable()->sortable(),
            // Column::make('Actions')

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

               
               
            // Button::add('Afficher')
            //     ->bladeComponent('button-show', function(Prestation $prestation) {
            //         return ['route' => route('contact.show', Crypt::encrypt($prestation->contact_id)),
            //         'tooltip' => "Afficher",
            //         'permission' => Gate::allows('permission', 'afficher-contact'),
                    
            //         ];
            //     }),
                
            Button::add('Modifier')
            ->bladeComponent('button-edit', function(Prestation $prestation) {
                return ['route' => route('prestation.edit', Crypt::encrypt($prestation->id)),
                'tooltip' => "Modifier",
                'permission' => Gate::allows('permission', 'modifier-contact'),
                
                ];
            }),
            
            Button::add('Archiver')
            ->bladeComponent('button-archive', function(Prestation $prestation) {
                return ['route' => route('prestation.archive', Crypt::encrypt($prestation->id)),
                'tooltip' => "Archiver",
                'classarchive' => "archive_prestation",
                'permission' => Gate::allows('permission', 'modifier-contact'),
                
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
