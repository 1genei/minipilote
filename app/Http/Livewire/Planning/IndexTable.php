<?php

namespace App\Http\Livewire\Planning;

use App\Models\Planning;
use Illuminate\Support\Facades\Crypt;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};
use Illuminate\Support\Facades\Gate;

final class IndexTable extends PowerGridComponent
{
    use ActionButton;

    public string $sortField = 'date';
    public string $sortDirection = 'desc';

    public function setUp(): array
    {
        return [
            Header::make()->showSearchInput()->showToggleColumns(),
            Footer::make()->showPerPage()->showRecordCount(),
        ];
    }

    public function datasource()
    {
        return Planning::query()
            ->where('est_modele', false)
            ->where('est_archive', false)
            ->with(['circuit', 'evenement'])
            ->orderBy('date', 'desc');
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('nom', function (Planning $model) {
                $url = route('planning.edit', Crypt::encrypt($model->id));
                return '<a href="' . $url . '" class="fw-semibold text-decoration-none">' . e($model->nom ?? '-') . '</a>';
            })
            ->addColumn('date', function (Planning $model) {
                return $model->date
                    ? \Carbon\Carbon::parse($model->date)->format('d/m/Y')
                    : '-';
            })
            ->addColumn('horaires', function (Planning $model) {
                if ($model->heure_debut && $model->heure_fin) {
                    return e($model->heure_debut) . ' – ' . e($model->heure_fin);
                }
                return '-';
            })
            ->addColumn('circuit_nom', function (Planning $model) {
                return $model->circuit
                    ? '<span class="badge bg-secondary">' . e($model->circuit->nom) . '</span>'
                    : '<span class="text-muted">-</span>';
            })
            ->addColumn('evenement_nom', function (Planning $model) {
                return $model->evenement
                    ? e($model->evenement->nom)
                    : '<span class="text-muted">-</span>';
            })
            ->addColumn('statut', function (Planning $model) {
                $badges = [
                    'actif'    => 'success',
                    'brouillon' => 'secondary',
                    'archive'  => 'warning',
                ];
                $badge = $badges[$model->statut] ?? 'secondary';
                return $model->statut
                    ? '<span class="badge bg-' . $badge . '">' . e(ucfirst($model->statut)) . '</span>'
                    : '-';
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Nom', 'nom')->searchable()->sortable(),
            Column::make('Date', 'date')->sortable(),
            Column::make('Horaires', 'horaires'),
            Column::make('Circuit', 'circuit_nom')->searchable(),
            Column::make('Événement', 'evenement_nom')->searchable(),
            Column::make('Statut', 'statut')->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datepicker('date', 'date'),
        ];
    }

    public function actions(): array
    {
        return [
            Button::add('Modifier')
                ->bladeComponent('button-edit', function (Planning $planning) {
                    return [
                        'route'      => route('planning.edit', Crypt::encrypt($planning->id)),
                        'tooltip'    => 'Modifier',
                        'permission' => Gate::allows('permission', 'modifier-planning'),
                    ];
                }),

            Button::add('Archiver')
                ->bladeComponent('button-archive', function (Planning $planning) {
                    return [
                        'route'        => route('planning.archiver', Crypt::encrypt($planning->id)),
                        'tooltip'      => 'Archiver',
                        'classarchive' => 'archive_planning',
                        'permission'   => Gate::allows('permission', 'modifier-planning'),
                    ];
                }),

            Button::add('Supprimer')
                ->bladeComponent('button-delete', function (Planning $planning) {
                    return [
                        'route'      => route('planning.destroy', Crypt::encrypt($planning->id)),
                        'tooltip'    => 'Supprimer',
                        'class'      => 'delete_planning',
                        'permission' => Gate::allows('permission', 'supprimer-planning'),
                    ];
                }),
        ];
    }

    public function actionRules(): array
    {
        return [];
    }
}
