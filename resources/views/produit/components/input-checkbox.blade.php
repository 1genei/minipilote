<ul>
    @if (isset($produit))
        @foreach ($categories as $categorie)
            <li>
                <label>
                    <input type="checkbox" @if (in_array($categorie->id, $produit->categorieproduitsId())) checked @endif name="categories_id[]"
                        wire:model.defer="categories_id" value="{{ $categorie->id }}">
                    {{ $categorie->nom }}
                </label>
                @if ($categorie->sscategories->count() > 0)
                    @include('produit.components.input-checkbox', [
                        'categories' => $categorie->sscategories,
                    ])
                @endif
            </li>
        @endforeach
    @else
        @foreach ($categories as $categorie)
            <li>
                <label>
                    <input type="checkbox" name="categories_id[]" wire:model.defer="categories_id"
                        value="{{ $categorie->id }}">
                    {{ $categorie->nom }}
                </label>
                @if ($categorie->sscategories->count() > 0)
                    @include('produit.components.input-checkbox', [
                        'categories' => $categorie->sscategories,
                    ])
                @endif
            </li>
        @endforeach
    @endif
</ul>
