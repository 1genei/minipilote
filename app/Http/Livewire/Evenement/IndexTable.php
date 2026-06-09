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
    use WithExport;

    public string $sortField = 'date_debut';
    public string $sortDirection = 'desc';
    public string $onglet = 'en_cours';

    protected function getListeners(): array
    {
        return array_merge(parent::getListeners(), [
            'filtrerOnglet' => 'changerOnglet',
        ]);
    }

    public function changerOnglet(string $onglet): void
    {
        $this->onglet = $onglet;
    }

    public function setUp(): array
    {
        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput()->showToggleColumns(),
            Footer::make()->showPerPage()->showRecordCount(),
        ];
    }

    public function datasource()
    {
        $today = Carbon::today();

        $query = Evenement::where('archive', false)
            ->withCount('plannings');

        if ($this->onglet === 'en_cours') {
            $query->where(function ($q) use ($today) {
                $q->where('date_fin', '>=', $today)
                  ->orWhere(function ($q2) use ($today) {
                      $q2->whereNull('date_fin')->where('date_debut', '>=', $today);
                  })
                  ->orWhere(function ($q3) use ($today) {
                      $q3->whereNull('date_fin')->whereNull('date_debut');
                  });
            });
        } else {
            $query->where(function ($q) use ($today) {
                $q->where('date_fin', '<', $today)
                  ->orWhere(function ($q2) use ($today) {
                      $q2->whereNull('date_fin')->where('date_debut', '<', $today);
                  });
            });
        }

        return $query->orderBy('date_debut', 'desc')->get();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('nom', function (Evenement $model) {
                return '<a href="' . route('evenement.show', Crypt::encrypt($model->id)) . '" class="badge bg-info text-white font-bold py-1 px-2 fs-6">' . e($model->nom) . ' <i class="mdi mdi-link"></i></a>';
            })
            ->addColumn('date_debut', function (Evenement $model) {
                if (!$model->date_debut) return '-';
                if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $model->date_debut)) return $model->date_debut;
                return Carbon::parse($model->date_debut)->format('d/m/Y');
            })
            ->addColumn('date_fin', function (Evenement $model) {
                if (!$model->date_fin) return '-';
                if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $model->date_fin)) return $model->date_fin;
                return Carbon::parse($model->date_fin)->format('d/m/Y');
            })
            ->addColumn('circuit_id', function (Evenement $model) {
                return '<span class="badge bg-warning text-white font-bold py-1 px-2 fs-6">' . e($model->circuit?->nom ?? '-') . '</span>';
            })
            ->addColumn('est_planifie', function (Evenement $model) {
                if ($model->plannings_count > 0) {
                    return '<span class="badge bg-success"><i class="mdi mdi-check-circle me-1"></i>Planifié</span>';
                }
                return '<span class="badge bg-secondary"><i class="mdi mdi-clock-outline me-1"></i>Non planifié</span>';
            })
            ->addColumn('recette', function (Evenement $model) {
                return '<span class="badge bg-success">' . number_format($model->recette(), 2, ',', ' ') . ' €</span>';
            })
            ->addColumn('depenses', function (Evenement $model) {
                return '<span class="badge bg-danger">' . number_format($model->montantDepenses(), 2, ',', ' ') . ' €</span>';
            })
            ->addColumn('marge', function (Evenement $model) {
                $marge = $model->benefices();
                $class = $marge >= 0 ? 'primary' : 'danger';
                return '<span class="badge bg-' . $class . '">' . number_format($marge, 2, ',', ' ') . ' €</span>';
            })
            ->addColumn('prestations_count', function (Evenement $model) {
                return '<span class="badge bg-secondary">' . $model->plannings_count . '</span>';
            });
    }

    public function columns(): array
    {
        $colums = [
            Column::make('Nom', 'nom')->searchable()->sortable(),
            Column::make('Date de début', 'date_debut')->searchable()->sortable(),
            Column::make('Date de fin', 'date_fin')->searchable()->sortable(),
            Column::make('Circuit', 'circuit_id')->searchable()->sortable(),
            Column::make('Planifié', 'est_planifie'),
            Column::make('Prestations', 'prestations_count'),
            Column::make('Recettes', 'recette'),
            Column::make('Dépenses', 'depenses'),
            Column::make('Marge', 'marge'),
        ];

        if (Auth::user()->is_admin) {
            $colums[] = Column::make('Saisi par', 'user')->sortable();
        }

        return $colums;
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(): array
    {
        return [
            Button::add('Afficher')
                ->bladeComponent('button-show', function (Evenement $evenement) {
                    return [
                        'route'      => route('evenement.show', Crypt::encrypt($evenement->id)),
                        'tooltip'    => 'Afficher',
                        'permission' => Gate::allows('permission', 'afficher-evenement'),
                    ];
                }),

            Button::add('Modifier')
                ->bladeComponent('button-edit', function (Evenement $evenement) {
                    return [
                        'route'      => route('evenement.edit', Crypt::encrypt($evenement->id)),
                        'tooltip'    => 'Modifier',
                        'permission' => Gate::allows('permission', 'modifier-evenement'),
                    ];
                }),

            Button::add('Archiver')
                ->bladeComponent('button-archive', function (Evenement $evenement) {
                    return [
                        'route'        => route('evenement.archive', Crypt::encrypt($evenement->id)),
                        'tooltip'      => 'Archiver',
                        'classarchive' => 'archive_evenement',
                        'permission'   => Gate::allows('permission', 'modifier-evenement'),
                    ];
                }),
        ];
    }

    public function actionRules(): array
    {
        return [];
    }
}
