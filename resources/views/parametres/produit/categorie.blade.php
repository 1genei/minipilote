<tr>
    <td>
        @if($categorie->parent_id)
            @if ($categorie->sscategories->count() > 0)
                <span style="margin-left: {{ ($categorie->niveau - 1) * 33 }}px;" class="mdi mdi-folder mr-2"></span>
            @else
                <span style="margin-left: {{ ($categorie->niveau - 1) * 33 }}px;" class="mdi mdi-file mr-2"></span>
            @endif
        @else
            @if ($categorie->sscategories->count() > 0)
                <span class="mdi mdi-folder mr-2"></span>
            @else 
                <span class="mdi mdi-file mr-2"></span>
            @endif
        @endif
        {{ $categorie->nom }}
    </td>
    <td>
        {{ $categorie->description }}
    </td>
    <td>
        @if ($categorie->archive)
            <button type="button" class="btn-danger btn-sm rounded-pill">Archivée</button>
        @else
            <button type="button" class="btn-success btn-sm rounded-pill">Active</button>
        @endif
    </td>
    <td>
        <a data-href="{{ route('categorieproduit.update', Crypt::encrypt($categorie->id)) }}" style="cursor: pointer;" title="Modifier"
                data-value="{{ $categorie->nom }}" data-bs-toggle="modal"
                data-bs-target="#edit-modal-categorie" class="action-icon edit_categorie text-primary">
            <i class="mdi mdi-square-edit-outline"></i>
        </a>
        @if ($categorie->archive == false)
            <a data-href="{{ route('categorieproduit.archive', Crypt::encrypt($categorie->id)) }}"
                style="cursor: pointer;" title="Archiver"
                class="action-icon archive_categorie text-warning">
                <i class="mdi mdi-archive-arrow-down"></i>
            </a>
        @else
            @if ($categorie->niveau == 1 || !$categorie->parent->archive)
                <a data-href="{{ route('categorieproduit.unarchive', Crypt::encrypt($categorie->id)) }}"
                    style="cursor: pointer;" title="Restaurer"
                    class="action-icon unarchive_categorie text-info">
                    <i class="mdi mdi-archive-arrow-up"></i>
                </a>
            @endif
        @endif
    </td>
</tr>
@if($categorie->sscategories->count() > 0)
    @foreach($categorie->sscategories as $sscategorie)
        @include('parametres.produit.categorie', ['categorie' => $sscategorie])
    @endforeach
@endif
