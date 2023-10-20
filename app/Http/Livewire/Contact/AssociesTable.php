<?php

namespace App\Http\Livewire\Contact;

use App\Models\Contact;
use App\Models\Individu;
use App\Models\EntiteIndividu;
use Crypt;
use Auth;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};
use Illuminate\Support\Facades\Gate;


final class AssociesTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;
    public $entite_id;
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
    
        $individus_existants = EntiteIndividu::where([['entite_id', intval($this->entite_id)]])->get();
        $ids_existant = array();
        
        foreach ($individus_existants as $ind) {
            array_push($ids_existant, $ind->individu_id); 
        }
        
        $contactsassocies = Individu::select('individus.*','contacts.*','contact_typecontact.*','typecontacts.type')
                ->join('contacts', 'individus.contact_id', '=', 'contacts.id')
                ->join('contact_typecontact', 'contacts.id', '=', 'contact_typecontact.contact_id')
                ->join('typecontacts', 'contact_typecontact.typecontact_id', '=', 'typecontacts.id')
                ->where([['contacts.type', 'individu'],['contacts.archive', false]])
                ->whereIn('individus.id', $ids_existant)
                ->get();

        return $contactsassocies;

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
            ->addColumn('type', function (Individu $model) {
                if($model->type == "Prospect"){
                    $color = "btn-secondary ";
                }elseif($model->type == "Client"){
                    $color = "btn-info";                
                }elseif($model->type == "Fournisseur"){
                    $color = "btn-warning";                
                }
                elseif($model->type == "Collaborateur"){
                    $color = "btn-danger";                
                }
                else{
                    $color = "btn-light ";                
                }
                return  '<button type="button" class="btn '.$color.' btn-sm rounded-pill">'.$model->type.'</button>';
            } )
            ->addColumn('nom')
            ->addColumn('prenom')
            ->addColumn('email',fn (Individu $model) => decode_string($model->email))
            ->addColumn('telephone_fixe')
            ->addColumn('telephone_mobile')
            ->addColumn('adresse')
            ->addColumn('code_postal')
            ->addColumn('ville')
            ->addColumn('created_at_formatted', fn (Individu $model) => Carbon::parse($model->created_at)->format('d/m/Y'));
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
            Column::make('Prénom', 'prenom')->sortable()->searchable(),
            Column::make('Email', 'email')->sortable()->searchable(),
            //Column::make('Téléphone Fixe', 'telephone_fixe')->sortable()->searchable(),
            Column::make('Téléphone Mobile', 'telephone_mobile')->sortable()->searchable(),
            //Column::make('Adresse', 'adresse')->sortable()->searchable(),
            //Column::make('Code Postal', 'code_postal')->sortable()->searchable(),
            Column::make('Ville', 'ville')->sortable()->searchable(),
            //Column::make('Date de création', 'created_at_formatted', 'created_at')->sortable(),

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
                ->bladeComponent('button-show', function(Individu $individu) {
                    return ['route' => route('contact.show', Crypt::encrypt($individu->contact_id)),
                    'tooltip' => "Afficher",
                    'permission' => Gate::allows('permission', 'afficher-contact'),
                    
                    ];
                }),
                
            Button::add('Modifier')
            ->bladeComponent('button-edit', function(Individu $individu) {
                return ['route' => route('contact.edit', Crypt::encrypt($individu->contact_id)),
                'tooltip' => "Modifier",
                'permission' => Gate::allows('permission', 'modifier-contact'),
                
                ];
            }),
            
            Button::add('Retirer')
            ->bladeComponent('button-delete', function(Individu $individu) {
                return ['route' => route('contact.deassociate', [intval($this->entite_id), $individu->contact_id] ),
                'tooltip' => "Retirer",
                'class' => "dissocier_individu",
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
