<?php

namespace App\Http\Livewire\Contrat;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

final class ContratTable extends PowerGridComponent
{
    use ActionButton;

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */
    public function datasource(): ?Collection
    {
 
        return collect([
            
        ]);
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
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
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
    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('Collaborateur')
            ->addColumn('Statut')
            ->addColumn('Période')
            ->addColumn('Société')
            ->addColumn('parrain')
            ->addColumn('action')
            // ->addColumn('created_at_formatted', function ($entry) {
            //     return Carbon::parse($entry->created_at)->format('d/m/Y');
            // })
            ;
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
            Column::make('Collaborateur', 'Collaborateur')
                ->searchable()
                ->sortable(),

            Column::make('Statut', 'Statut')
                ->searchable()
                ->sortable(),

            Column::make('Période', 'Période')
                ->sortable(),
            Column::make('Société', 'Société')
            ->sortable(),
            Column::make('parrain', 'parrain')
            ->sortable(),
            Column::make('Action', 'Action')
            ->sortable(),

            // Column::make('Created', 'created_at_formatted'),
        ];
    }
}
