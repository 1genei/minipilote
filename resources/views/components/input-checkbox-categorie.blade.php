<ul>
    @foreach ($categories as $categorie)
        <li>
            <label>
                <input type="checkbox" name="categories_id[]" wire:model.defer="categories_id" value="{{ $categorie->id }}">
                {{ $categorie->nom }}
            </label>
            @if ($categorie->sscategories->count() > 0)
                @include('components.input-checkbox-categorie', ['categories' => $categorie->sscategories])
            @endif
        </li>
    @endforeach
</ul>
