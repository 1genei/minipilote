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

final class CommandeArchiveTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;

    public string $sortField = 'date_commande';
    public string $sortDirection = 'desc';

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
                ->showPerPage(25)
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Commande::query()
            ->where('archive', true)
            ->with(['client', 'produits']);
    }

    public function relationSearch(): array
    {
        return [
            'client' => ['nom', 'prenom', 'raison_sociale'],
        ];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('numero_commande', function(Commande $model) {
                return '<a href="'.route('commande.show', Crypt::encrypt($model->id)).'">'.$model->numero_commande.'</a>';
            })
            ->addColumn('date_commande', function(Commande $model) {
                return Carbon::parse($model->date_commande)->format('d/m/Y');
            })
            ->addColumn('client', function(Commande $model) {
                if($model->client->type == 'individu') {
                    return $model->client->individu->nom . ' ' . $model->client->individu->prenom;
                } else {
                    return $model->client->entite->raison_sociale;
                }
            })
            ->addColumn('montant_ht', function(Commande $model) {
                return number_format($model->montant_ht, 2, ',', ' ') . ' €';
            })
            ->addColumn('montant_ttc', function(Commande $model) {
                return number_format($model->montant_ttc, 2, ',', ' ') . ' €';
            })
            ->addColumn('statut_commande', function(Commande $model) {
                $badges = [
                    'A planifier' => 'warning',
                    'Planifiée' => 'info',
                    'Exécutée' => 'success',
                    'Annulée' => 'danger'
                ];
                $badge = $badges[$model->statut_commande] ?? 'secondary';
                return '<span class="badge bg-'.$badge.'">' . $model->statut_commande . '</span>';
            })
            ->addColumn('statut_paiement', function(Commande $model) {
                $badges = [
                    'A payer' => 'danger',
                    'Payée' => 'success',
                    'Partiellement payée' => 'warning',
                    'Annulée' => 'danger',
                    'Sans suite' => 'secondary'
                ];
                $badge = $badges[$model->statut_paiement] ?? 'secondary';
                return '<span class="badge bg-'.$badge.'">' . $model->statut_paiement . '</span>';
            })
            ->addColumn('date_realisation_prevue', function(Commande $model) {
                return $model->date_realisation_prevue ? Carbon::parse($model->date_realisation_prevue)->format('d/m/Y') : '';
            })
            ->addColumn('date_archivage', function(Commande $model) {
                return $model->updated_at->format('d/m/Y H:i');
            })
            ->addColumn('action', function(Commande $model) {
                $actions = '';
                
                if(Gate::allows('permission', 'afficher-commande')) {
                    $actions .= '<a href="'.route('commande.show', Crypt::encrypt($model->id)).'" class="btn btn-sm btn-primary me-1" title="Voir"><i class="mdi mdi-eye"></i></a>';
                }
                
                if(Gate::allows('permission', 'archiver-commande')) {
                    $actions .= '<button class="btn btn-sm btn-success desarchiver_commande" title="Désarchiver" data-href="'.route('commande.desarchiver', Crypt::encrypt($model->id)).'"><i class="mdi mdi-archive-arrow-up"></i></button>';
                }
                
                return $actions;
            });
    }

    public function columns(): array
    {
        return [
            Column::make('N° Commande', 'numero_commande')
                ->sortable()
                ->searchable(),
                
            Column::make('Date', 'date_commande')
                ->sortable(),
                
            Column::make('Client', 'client')
                ->sortable()
                ->searchable(),
                
            Column::make('Montant HT', 'montant_ht')
                ->sortable(),
                
            Column::make('Montant TTC', 'montant_ttc')
                ->sortable(),
                
            Column::make('Statut', 'statut_commande')
                ->sortable()
                ->searchable(),
                
            Column::make('Paiement', 'statut_paiement')
                ->sortable()
                ->searchable(),
                
            Column::make('Date prévue', 'date_realisation_prevue')
                ->sortable(),
                
            Column::make('Archivée le', 'date_archivage')
                ->sortable(),
                
            Column::make('Actions', 'action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('numero_commande')->operators(['contains']),
            Filter::datepicker('date_commande'),
            Filter::datepicker('date_realisation_prevue'),
            Filter::select('statut_commande', 'statut_commande')
                ->dataSource([
                    ['value' => 'A planifier', 'label' => 'A planifier'],
                    ['value' => 'Planifiée', 'label' => 'Planifiée'],
                    ['value' => 'Exécutée', 'label' => 'Exécutée'],
                    ['value' => 'Annulée', 'label' => 'Annulée'],
                ])
                ->optionValue('value')
                ->optionLabel('label'),
            Filter::select('statut_paiement', 'statut_paiement')
                ->dataSource([
                    ['value' => 'A payer', 'label' => 'A payer'],
                    ['value' => 'Payée', 'label' => 'Payée'],
                    ['value' => 'Partiellement payée', 'label' => 'Partiellement payée'],
                    ['value' => 'Annulée', 'label' => 'Annulée'],
                    ['value' => 'Sans suite', 'label' => 'Sans suite'],
                ])
                ->optionValue('value')
                ->optionLabel('label'),
        ];
    }
} 