<?php

namespace App\Http\Livewire\Facture;

use App\Models\Facture;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};
use Illuminate\Support\Facades\Gate;

final class IndexTable extends PowerGridComponent
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
     * @return Builder<\App\Models\Facture>
     */
    public function datasource()
    {
        return Facture::query()
            ->with(['client', 'fournisseur', 'commande', 'user'])
            ->orderBy('created_at', 'desc');
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
            'client' => [
                'individu.nom',
                'individu.prenom',
                'entite.raison_sociale',
            ],
            'fournisseur' => [
                'individu.nom',
                'individu.prenom',
                'entite.raison_sociale',
            ],
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
            ->addColumn('numero', function (Facture $model) {
                return '<span class="badge bg-primary">' . e($model->numero) . '</span>';
            })
            ->addColumn('date', function (Facture $model) {
                // return \Carbon\Carbon::parse( $model->date)->format('d/m/Y');
                return "2025-06-30";
            })
            ->addColumn('type', function (Facture $model) {
                $badges = [
                    'client' => 'success',
                    'fournisseur' => 'warning',
                    'directe' => 'info'
                ];
                $badge = $badges[$model->type] ?? 'secondary';
                return '<span class="badge bg-' . $badge . '">' . ucfirst(e($model->type)) . '</span>';
            })
            ->addColumn('client_nom', function (Facture $model) {
                if ($model->client) {
                    $nom = $model->client->type == 'individu' 
                        ? $model->client->individu->nom . ' ' . $model->client->individu->prenom
                        : $model->client->entite->raison_sociale;
                    return '<span class="text-muted">' . e($nom) . '</span>';
                }
                return '<span class="text-muted">-</span>';
            })
            ->addColumn('fournisseur_nom', function (Facture $model) {
                if ($model->fournisseur) {
                    $nom = $model->fournisseur->type == 'individu' 
                        ? $model->fournisseur->individu->nom . ' ' . $model->fournisseur->individu->prenom
                        : $model->fournisseur->entite->raison_sociale;
                    return '<span class="text-muted">' . e($nom) . '</span>';
                }
                return '<span class="text-muted">-</span>';
            })
            // ->addColumn('montant_ht', function (Facture $model) {
            //     return '<span class="fw-bold">' . number_format($model->montant_ht, 2, ',', ' ') . ' €</span>';
            // })
            // ->addColumn('montant_ttc', function (Facture $model) {
            //     return '<span class="fw-bold text-primary">' . number_format($model->montant_ttc, 2, ',', ' ') . ' €</span>';
            // })
            // ->addColumn('net_a_payer', function (Facture $model) {
            //     return '<span class="fw-bold text-success">' . number_format($model->net_a_payer, 2, ',', ' ') . ' €</span>';
            // })
            ->addColumn('statut_paiement', function (Facture $model) {
                $badges = [
                    'attente paiement' => 'warning',
                    'partiellement payée' => 'warning',
                    'payée' => 'success'
                ];
                $labels = [
                    'attente paiement' => 'Attente paiement',
                    'partiellement payée' => 'Partiellement payée',
                    'payée' => 'Payée'
                ];
                $badge = $badges[$model->statut_paiement] ?? 'secondary';
                $label = $labels[$model->statut_paiement] ?? $model->statut_paiement;
                return '<span class="badge bg-' . $badge . '">' . e($label) . '</span>';
            })
            // ->addColumn('statut', function (Facture $model) {
            //     $badges = [
            //         'brouillon' => 'secondary',
            //         'envoyee' => 'info',
            //         'payee' => 'success',
            //         'annulee' => 'danger'
            //     ];
            //     $labels = [
            //         'brouillon' => 'Brouillon',
            //         'envoyee' => 'Envoyée',
            //         'payee' => 'Payée',
            //         'annulee' => 'Annulée'
            //     ];
            //     $badge = $badges[$model->statut] ?? 'secondary';
            //     $label = $labels[$model->statut] ?? $model->statut;
            //     return '<span class="badge bg-' . $badge . '">' . e($label) . '</span>';
            // })
            // ->addColumn('user_nom', function (Facture $model) {
            //     return $model->user ? e($model->user->name) : '-';
            // });
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
        $columns = [
            Column::make('Numéro', 'numero')->searchable()->sortable(),
            Column::make('Date', 'date')->sortable(),
            Column::make('Type', 'type')->searchable()->sortable(),
            Column::make('Client', 'client_nom')->searchable()->sortable(),
            Column::make('Fournisseur', 'fournisseur_nom')->searchable()->sortable(),
            Column::make('Montant HT', 'montant_ht')->sortable(),
            Column::make('Montant TTC', 'montant_ttc')->sortable(),
            // Column::make('Net à payer', 'net_a_payer')->sortable(),
            Column::make('Statut paiement', 'statut_paiement')->sortable(),
            // Column::make('Statut', 'statut')->sortable(),
        ];

        // if (Auth::user()->is_admin) {
        //     $columns[] = Column::make('Créé par', 'user_nom')->sortable();
        // }

        return $columns;
    }

    /**
     * PowerGrid Filters.
     *
     * @return array<int, Filter>
     */
    public function filters(): array
    {
        return [
            Filter::select('type', 'type')
                ->dataSource(Facture::select('type')->distinct()->get())
                ->optionValue('type')
                ->optionLabel('type'),
            Filter::select('statut_paiement', 'statut_paiement')
                ->dataSource([
                    ['statut_paiement' => 'attente paiement', 'label' => 'Attente paiement'],
                    ['statut_paiement' => 'partiellement payée', 'label' => 'Partiellement payée'],
                    ['statut_paiement' => 'payée', 'label' => 'Payée'],
                ])
                ->optionValue('statut_paiement')
                ->optionLabel('label'),
            Filter::select('statut', 'statut')
                ->dataSource([
                    ['statut' => 'brouillon', 'label' => 'Brouillon'],
                    ['statut' => 'envoyee', 'label' => 'Envoyée'],
                    ['statut' => 'payee', 'label' => 'Payée'],
                    ['statut' => 'annulee', 'label' => 'Annulée'],
                ])
                ->optionValue('statut')
                ->optionLabel('label'),
            Filter::datepicker('date', 'date'),
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
     * PowerGrid Facture Action Buttons.
     *
     * @return array<int, Button>
     */
    public function actions(): array
    {
        return [
            Button::add('Afficher')
                ->bladeComponent('button-show', function(Facture $facture) {
                    return [
                        'route' => route('facture.show', Crypt::encrypt($facture->id)),
                        'tooltip' => "Afficher",
                        'permission' => Gate::allows('permission', 'afficher-facture'),
                    ];
                }),

            Button::add('Modifier')
                ->bladeComponent('button-edit', function(Facture $facture) {
                    return [
                        'route' => route('facture.edit', Crypt::encrypt($facture->id)),
                        'tooltip' => "Modifier",
                        'permission' => Gate::allows('permission', 'modifier-facture'),
                    ];
                }),

            Button::add('PDF')
                ->bladeComponent('button-edit', function(Facture $facture) {
                    return [
                        'route' => route('facture.pdf', Crypt::encrypt($facture->id)),
                        'tooltip' => "Générer PDF",
                        'permission' => Gate::allows('permission', 'modifier-facture'),
                    ];
                }),

            Button::add('Archiver')
                ->bladeComponent('button-archive', function(Facture $facture) {
                    return [
                        'route' => route('facture.archive', Crypt::encrypt($facture->id)),
                        'tooltip' => "Archiver",
                        'classarchive' => "archive_facture",
                        'permission' => Gate::allows('permission', 'modifier-facture'),
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
     * PowerGrid Facture Action Rules.
     *
     * @return array<int, RuleActions>
     */
    public function actionRules(): array
    {
        return [];
    }
} 