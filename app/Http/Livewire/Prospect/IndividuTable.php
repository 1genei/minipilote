<?php

namespace App\Http\Livewire\Prospect;

use App\Models\Contact;
use App\Models\Individu;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};
use Illuminate\Support\Facades\Gate;

final class IndividuTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;
    public $contactindividus;
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
                ->showPerPage(30)
                ->showRecordCount()
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

        // if ($user->is_admin) {

            // On réccupère tous les contacts de type individu
                
            $contactindividus = Individu::query()
                ->select('individus.*','contacts.id as contact_id', 'tags.nom as tag_nom','contacts.created_at as contact_created_at')
                ->join('contacts', 'individus.contact_id', '=', 'contacts.id')
                ->join('contact_typecontact', 'contacts.id', '=', 'contact_typecontact.contact_id')
                ->join('typecontacts', 'contact_typecontact.typecontact_id', '=', 'typecontacts.id')
                ->leftJoin('contact_tag', 'contacts.id', '=', 'contact_tag.contact_id')
                ->leftJoin('tags', 'contact_tag.tag_id', '=', 'tags.id')
                ->where([['contacts.type', 'individu'],['contacts.archive', false]])
                ->where('typecontacts.type', 'Prospect')
                ->distinct();

        // } else {
        //     //   On réccupère uniquement les contacts de l'utilisateur connecté
                
        //     $contactindividus = Individu::select('individus.*','contacts.*')
        //         ->join('contacts', 'individus.contact_id', '=', 'contacts.id')
        //         ->join('contact_typecontact', 'contacts.id', '=', 'contact_typecontact.contact_id')
        //         ->join('typecontacts', 'contact_typecontact.typecontact_id', '=', 'typecontacts.id')
        //         ->where([['contacts.type', 'individu'],['contacts.archive', false], ["contacts.user_id", $user->id]])
        //         ->where('typecontacts.type', 'Prospect')
        //         ->get();
        // }
    
       
        
        return $contactindividus;

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
            ->addColumn('tag_nom', function (Individu $model) {
                $tags = "";
                if($model->contact && $model->contact->tags) {
                    foreach($model->contact->tags as $tag) {
                        $tags .= '<div class="badge bg-primary btn-sm font-11 mt-2 me-1">'.$tag->nom.'</div> ';
                    }
                }
                return $tags;
            })
            ->addColumn('nom', function (Individu $model) {
                return '<a href="'.route('contact.show', Crypt::encrypt($model->contact_id)).'" class="text-dark">
                <span class="fw-bold">'.$model->civilite.'</span> <span>'.$model->nom.' </span>
                <i class="mdi mdi-link-variant"></i>
                </a>';
            })
            ->addColumn('prenom', function (Individu $model) {
                return '<a href="'.route('contact.show', Crypt::encrypt($model->contact_id)).'" class="text-dark">
                '.$model->prenom.'
                </a>';
            })
            ->addColumn('source_contact', function (Individu $model) {
                return '<span class="fw-bold">'.$model->contact?->source_contact.'</span>';
            })
            ->addColumn('email', fn (Individu $model) => $model->email)
            ->addColumn('telephone', function(Individu $model) {
                $tel = '';
                if($model->telephone_mobile) {
                    $tel .= '<span>'.$model->indicatif_mobile.' '.$model->telephone_mobile.'</span>';
                }
                if($model->telephone_fixe) {
                    $tel .= '<br><span>'.$model->indicatif_fixe.' '.$model->telephone_fixe.'</span>';
                }
                return $tel;
            })
            ->addColumn('adresse', function (Individu $model) {          
                return '<span>'.$model->numero_voie.' '.$model->nom_voie.', <br> '.$model->code_postal.' - '.$model->ville.'</span>';
            })
            ->addColumn('user', function (Individu $model) {          
                return '<span>'.$model->user()?->infos()?->nom.' '.$model->user()?->infos()?->prenom.'</span>';
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
        $colums = [
            Column::make('Tags', 'tag_nom')->sortable()->searchable(),
            Column::make('Nom', 'nom')->sortable()->searchable(),
            Column::make('Prénom', 'prenom')->sortable()->searchable(),
            Column::make('Source du contact', 'source_contact')->sortable()->searchable(),
            Column::make('Email', 'email')->sortable()->searchable(),
            Column::make('Téléphone', 'telephone')->sortable()->searchable(),
            Column::make('Adresse', 'adresse')->sortable()->searchable(),
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
                    'permission' => Gate::allows('permission', 'afficher-prospect'),
                    
                    ];
                }),
                
            Button::add('Modifier')
            ->bladeComponent('button-edit', function(Individu $individu) {
                return ['route' => route('contact.edit', Crypt::encrypt($individu->contact_id)),
                'tooltip' => "Modifier",
                'permission' => Gate::allows('permission', 'modifier-prospect'),
                
                ];
            }),
            
            Button::add('Archiver')
            ->bladeComponent('button-archive', function(Individu $individu) {
                return ['route' => route('contact.archive', Crypt::encrypt($individu->contact_id)),
                'tooltip' => "Archiver",
                'classarchive' => "archive_contact",
                'permission' => Gate::allows('permission', 'archiver-prospect'),
                
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
