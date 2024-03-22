<div class="table-responsive">
    {{-- <table class="table table-centered table-nowrap table-striped table-bordered w-100" id="dt-prestations"> --}}
    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
        <thead>
            <tr>
                <th>Type</th>
                <th>Libellé</th>
                <th>Description</th>
                <th>Montant</th>
                <th>Date</th>
                <th>Action </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($depenses as $depense)
                <tr>
                    <td> <span class="text-primary">{{ $depense->numero }}</span></td>
                    <td>{{ $depense?->produit?->nom }}</td>
                    <td><span class="text-danger"> {{ $depense?->voiture?->nom }} </span> </td>
                    <td>{{ number_format($depense->montant_ttc, 2, ',', ' ') }} €</td>
                    <td>
                        @if ($depense->client()->type == 'individu')
                            {{ $depense->client()?->individu->nom }} {{ $depense->client()?->individu->prenom }}
                        @else
                            {{ $depense->client()?->entite->nom }}
                        @endif


                    </td>
                    <td> {{ $depense->beneficiaire()->individu->nom }}
                        {{ $depense->beneficiaire()->individu->prenom }}</td>
                    <td>{{ number_format($depense->montantCharges(), 2, ',', ' ') }} €</td>
                    <td>
                        @if ($depense->statut == 'Confirmé')
                            <span class="text-primary">{{ $depense->statut }} </span>
                        @else
                            <span class="text-default"> {{ $depense->statut }}</span>
                        @endif

                    <td>
                        <a href="{{ route('prestation.edit', [Crypt::encrypt($depense->id), $evenement->id]) }}"
                            class="btn btn-primary btn-sm"><i class="mdi mdi-square-edit-outline"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
