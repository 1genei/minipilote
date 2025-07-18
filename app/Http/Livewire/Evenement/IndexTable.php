<?php

namespace App\Http\Livewire\Evenement;

use App\Models\Evenement;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

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
    use ActionButton;
    use WithExport;

    public string $sortField = 'created_at';
    
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
      
        $evenements = Evenement::where('archive', false)->orderBy('created_at', 'desc')->get();
        
        return $evenements;

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
      
            ->addColumn('nom', function (Evenement $model) {          
                return  '<a href="'.route('evenement.show', Crypt::encrypt($model->id)).'" class="badge bg-info text-white font-bold py-1 px-2 fs-6">'.$model->nom.' <i class="mdi mdi-link"></i></a>';
           
            } )
            ->addColumn('date_debut', function (Evenement $model) {
                return Carbon::parse($model->date_debut)->format('d/m/Y');
            })
           
            ->addColumn('date_fin', function (Evenement $model) {
                return Carbon::parse($model->date_fin)->format('d/m/Y');
            })
            ->addColumn('circuit_id', function (Evenement $model) {
                return  '<span class="badge bg-warning text-white font-bold py-1 px-2 fs-6">'.$model->circuit?->nom.'</span>';
            })
            ->addColumn('recette', function(Evenement $model) {
                return '<span class="badge bg-success">'.number_format($model->recette(), 2, ',', ' ').' €</span>';
            })
            ->addColumn('depenses', function(Evenement $model) {
                return '<span class="badge bg-danger">'.number_format($model->montantDepenses(), 2, ',', ' ').' €</span>';
            })
            ->addColumn('marge', function(Evenement $model) {
                $marge = $model->benefices();
                $class = $marge >= 0 ? 'primary' : 'danger';
                return '<span class="badge bg-'.$class.'">'.number_format($marge, 2, ',', ' ').' €</span>';
            })
            ->addColumn('prestations_count', function(Evenement $model) {
                return '<span class="badge bg-secondary">'.$model->prestations->count().'</span>';
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
    
        $colums =  [
     
            Column::make('Nom', 'nom')->searchable()->sortable(),
            Column::make('Date de début', 'date_debut',)->searchable()->sortable(),
            Column::make('Date de fin', 'date_fin')->searchable()->sortable(),
            Column::make('Circuit', 'circuit_id')->searchable()->sortable(),
            Column::make('Prestations', 'prestations_count'),
            Column::make('Recettes', 'recette'),
            Column::make('Dépenses', 'depenses'),
            Column::make('Marge', 'marge'),

        ];
        
        if(Auth::user()->is_admin ){
             $colums[] = Column::make('Saisi par', 'user')->sortable();
        }
        
        return $colums;
    }

    /**
     * PowerGrid Filters.
     *
     * @return array<int, Filter>
     */
    public function filters(): array
    {
    
        return [
      
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
            ->bladeComponent('button-show', function(Evenement $evenement) {
                return ['route' => route('evenement.show', Crypt::encrypt($evenement->id)),
                'tooltip' => "Afficher",
                'permission' => Gate::allows('permission', 'afficher-evenement'),
                
                ];
            }),
                
            Button::add('Modifier')
            ->bladeComponent('button-edit', function(Evenement $evenement) {
                return ['route' => route('evenement.edit', Crypt::encrypt($evenement->id)),
                'tooltip' => "Modifier",
                'permission' => Gate::allows('permission', 'modifier-evenement'),
                
                ];
            }),
            
            Button::add('Archiver')
            ->bladeComponent('button-archive', function(Evenement $evenement) {
                return ['route' => route('evenement.archive', Crypt::encrypt($evenement->id)),
                'tooltip' => "Archiver",
                'classarchive' => "archive_evenement",
                'permission' => Gate::allows('permission', 'modifier-evenement'),
                
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
        ];
    }
}
