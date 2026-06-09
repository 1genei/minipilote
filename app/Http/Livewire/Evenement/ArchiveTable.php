<?php

namespace App\Http\Livewire\Evenement;

use App\Models\Evenement;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class ArchiveTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;

    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

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
        return Evenement::where('archive', true)->orderBy('created_at', 'desc')->get();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('nom', function (Evenement $model) {
                return '<span class="badge bg-secondary font-bold py-1 px-2 fs-6">' . e($model->nom) . '</span>';
            })
            ->addColumn('date_debut', function (Evenement $model) {
                return $model->date_debut ? Carbon::parse($model->date_debut)->format('d/m/Y') : '-';
            })
            ->addColumn('date_fin', function (Evenement $model) {
                return $model->date_fin ? Carbon::parse($model->date_fin)->format('d/m/Y') : '-';
            })
            ->addColumn('circuit_id', function (Evenement $model) {
                return '<span class="badge bg-warning text-white font-bold py-1 px-2">' . e($model->circuit?->nom ?? '-') . '</span>';
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Nom', 'nom')->searchable()->sortable(),
            Column::make('Date de début', 'date_debut')->searchable()->sortable(),
            Column::make('Date de fin', 'date_fin')->searchable()->sortable(),
            Column::make('Circuit', 'circuit_id')->searchable()->sortable(),
        ];
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(): array
    {
        return [
            Button::add('Désarchiver')
                ->bladeComponent('button-unarchive', function (Evenement $evenement) {
                    return [
                        'route'       => route('evenement.unarchive', Crypt::encrypt($evenement->id)),
                        'tooltip'     => 'Désarchiver',
                        'classunarchive' => 'unarchive_evenement',
                        'permission'  => Gate::allows('permission', 'modifier-evenement'),
                    ];
                }),
        ];
    }

    public function actionRules(): array
    {
        return [];
    }
}
