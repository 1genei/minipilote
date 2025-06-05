<?php

namespace App\Http\Livewire\Commande;

use App\Models\Commande;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Crypt;

final class CommandeTable extends PowerGridComponent
{
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
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()
                ->showSearchInput()
                ->showToggleColumns(),
            Footer::make()
                ->showPerPage(25)
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Eloquent, Query Builder or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder
     */
    public function datasource(): Builder
    {
        return Commande::query()
            ->where('archive', false);
            // ->with(['client', 'collaborateur']);
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
        return [
            'client' => ['nom', 'prenom', 'raison_sociale'],
            'collaborateur' => ['nom', 'prenom'],
        ];
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
            ->addColumn('numero_commande')
            ->addColumn('nom_commande')
            ->addColumn('date_commande_formatted', function(Commande $model) {
                return Carbon::parse($model->date_commande)->format('d/m/Y');
            })
            ->addColumn('client_name', function(Commande $model) {
                if($model->client->type == 'individu') {
                    return $model->client->individu->nom . ' ' . $model->client->individu->prenom;
                } else {
                    return $model->client->entite->raison_sociale;
                }
            })
            ->addColumn('collaborateur_name', function(Commande $model) {
                return $model->collaborateur ? $model->collaborateur->individu->nom . ' ' . $model->collaborateur->individu->prenom : '';
            })
            ->addColumn('montant_ttc', function(Commande $model) {
                return number_format($model->montant_ttc, 2) ;
            })
            ->addColumn('statut')
            ->addColumn('action', function(Commande $model) {
                $actions = '';
                
                if(Gate::allows('permission', 'voir-commande')) {
                    $actions .= '<a href="'.route('commande.show', Crypt::encrypt($model->id)).'" class="btn btn-sm btn-primary me-1" title="Voir"><i class="mdi mdi-eye"></i></a>';
                }
                
                if(Gate::allows('permission', 'modifier-commande')) {
                    $actions .= '<a href="'.route('commande.edit', Crypt::encrypt($model->id)).'" class="btn btn-sm btn-success me-1" title="Modifier"><i class="mdi mdi-square-edit-outline"></i></a>';
                }
                
                if(Gate::allows('permission', 'archiver-commande')) {
                    $actions .= '<button class="btn btn-sm btn-danger archive_commande" title="Archiver" data-href="'.route('commande.archiver', Crypt::encrypt($model->id)).'"><i class="mdi mdi-archive-arrow-down"></i></button>';
                }
                
                return $actions;
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
            Column::make('N° Commande', 'numero_commande')->sortable()->searchable(),
            Column::make('Nom', 'nom_commande')->sortable()->searchable(),
            Column::make('Date', 'date_commande_formatted')->sortable(),
            Column::make('Client', 'client_name')->sortable()->searchable(),
            Column::make('Commercial', 'collaborateur_name')->sortable()->searchable(),
            Column::make('Montant TTC', 'montant_ttc')->sortable(),
            Column::make('Statut', 'statut')->sortable()->searchable(),
            Column::make('Actions', 'action')
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
            Filter::inputText('numero_commande')->operators(['contains']),
            Filter::inputText('nom_commande')->operators(['contains']),
            Filter::datepicker('date_commande'),
            Filter::select('statut', 'statut')
                ->dataSource([
                    ['value' => 'en_cours', 'label' => 'En cours'],
                    ['value' => 'validee', 'label' => 'Validée'],
                    ['value' => 'livree', 'label' => 'Livrée'],
                    ['value' => 'annulee', 'label' => 'Annulée'],
                ])
                ->optionValue('value')
                ->optionLabel('label'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
