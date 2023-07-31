<?php

namespace App\Http\Livewire;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

final class ProspectIndividuPowerGrid extends PowerGridComponent 
{
    use ActionButton;

    public $data;

    /*
    Décommenter tout ça résout les erreurs de undefined mais donne une nouvelle erreur :
    core-app\resources\views\vendor\livewire-powergrid\components\inline-filters.blade
    count(): Argument #1 ($value) must be of type Countable|array, bool given
    */
    public $exportActive = false;
    public $makeFilters = array();
    public $toggleColumns = false;
    public $searchInput = false;
    public $queues = false;
    public $inputTextOptions = false;
    

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */
    public function datasource(): Collection
    {
        return collect($this->data);
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Header::make()
                ->withoutLoading(),
            Footer::make()
                ->showPerPage(25)
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('nom')
            ->addColumn('prenom')
            ->addColumn('email')
            ->addColumn('telephone')
            ->addColumn('adresse')
            ->addColumn('code_postal')
            ->addColumn('ville')
            ->addColumn('action');
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
            Column::make('Nom', 'nom')
                ->searchable()
                ->sortable(),

            Column::make('Prénom', 'prenom')
                ->searchable()
                ->sortable(),

            Column::make('Email', 'email')
                ->searchable()
                ->sortable(),

            Column::make('Téléphone', 'telephone')
                ->searchable()
                ->sortable(),

            Column::make('Adresse', 'adresse')
                ->searchable()
                ->sortable(),
            
            Column::make('Code Postal', 'code_postal')
                ->searchable()
                ->sortable(),
            
            Column::make('Ville', 'ville')
                ->searchable()
                ->sortable(),
            
            Column::make('Pays', 'pays')
                ->searchable()
                ->sortable(),
            
            Column::make('Action', 'action'),
        ];
    }

    public function filters(): array {
        return [
            Filter::inputText('nom')->operators(['contains']),
            Filter::inputText('prenom')->operators(['contains']),
            Filter::inputText('email')->operators(['contains']),
            Filter::inputText('telephone')->operators(['contains']),
            Filter::inputText('adresse')->operators(['contains']),
            Filter::inputText('code_postal')->operators(['contains']),
            Filter::inputText('ville')->operators(['contains']),
            Filter::inputText('pays')->operators(['contains']),
        ];
    }
}
