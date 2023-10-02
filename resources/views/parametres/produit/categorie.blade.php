<tr>
    <td>
        @if ($categorie->parent_id)
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
        <b>{{ $categorie->nom }}</b>
    </td>
    <td class="text-wrap w-50">
        {{ $categorie->description }}
    </td>
    <td>
        @if ($categorie->archive)
            <span class="badge bg-warning">Archivé</span>
        @else
            <span class="badge bg-success">Actif</span>
        @endif
    </td>
    <td>
        <a data-href="{{ route('categorieproduit.update', Crypt::encrypt($categorie->id)) }}" style="cursor: pointer;"
            title="Modifier" data-nom="{{ $categorie->nom }}" data-parent_id="{{ $categorie->parent_id }}"
            data-description="{{ $categorie->description }}" data-bs-toggle="modal"
            data-bs-target="#edit-modal-categorie" class="action-icon edit_categorie text-primary">
            <i class="mdi mdi-square-edit-outline"></i>
        </a>
        @if ($categorie->archive == false)
            <a data-href="{{ route('categorieproduit.archive', Crypt::encrypt($categorie->id)) }}"
                style="cursor: pointer;" title="Archiver" class="action-icon archive_categorie text-warning">
                <i class="mdi mdi-archive-arrow-down"></i>
            </a>
        @else
            @if ($categorie->niveau == 1 || !$categorie->parent->archive)
                <a data-href="{{ route('categorieproduit.unarchive', Crypt::encrypt($categorie->id)) }}"
                    style="cursor: pointer;" title="Restaurer" class="action-icon unarchive_categorie text-info">
                    <i class="mdi mdi-archive-arrow-up"></i>
                </a>
            @endif
        @endif
    </td>
</tr>
@if ($categorie->sscategories->count() > 0)
    @foreach ($categorie->sscategories as $sscategorie)
        @include('parametres.produit.categorie', ['categorie' => $sscategorie])
    @endforeach
@endif
