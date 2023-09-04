<form action="{{ route('produit.update', Crypt::encrypt($produit->id)) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal-content">
        <div class="modal-body">

            @csrf

            <ul class="nav nav-tabs nav-bordered mb-3">
                <li class="nav-item">
                    <a href="#essentiel-tab" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                        <i class="mdi mdi-home-variant d-md-none d-block"></i>
                        <span class="d-none d-md-block">Essentiel</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#prix-tab" data-bs-toggle="tab" aria-expanded="true" class="nav-link ">
                        <i class="mdi mdi-account-circle d-md-none d-block"></i>
                        <span class="d-none d-md-block">Prix</span>
                    </a>
                </li>
                @if ($type == 'declinaison')
                    <li class="nav-item">
                        <a href="#declinaison-tab" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                            <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                            <span class="d-none d-md-block">Déclinaisons</span>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="#stock-tab" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                        <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                        <span class="d-none d-md-block">Stock</span>
                    </a>
                </li>
            </ul>


            <div class="tab-content">
                <div class="tab-pane show active" id="essentiel-tab">
                    @include('produit.components.edit_essentiel')
                </div>
                <div class="tab-pane " id="prix-tab" wire:ignore>
                    @include('produit.components.edit_prix')

                </div>
                @if ($type == 'declinaison')
                    <div class="tab-pane" id="declinaison-tab">
                        @include('produit.components.edit_declinaison')
                    </div>
                @endif
                <div class="tab-pane" id="stock-tab" wire:ignore>
                    @include('produit.components.edit_stock')
                </div>
            </div>


        </div>
        <div class="modal-footer" style="position: fixed;bottom: 10px; margin: 0;  left: 50%; z-index:1 ;">
            <a class="btn btn-light btn-lg " href="{{ route('produit.index') }}">Annuler</a>
            <button type="submit" class="btn btn-dark btn-flat btn-addon btn-lg "
                wire:click="submit">Enregistrer</button>
        </div>


    </div>
</form>
