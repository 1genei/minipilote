<div class="table-responsive">
    {{-- <table class="table table-centered table-nowrap table-striped table-bordered w-100" id="dt-prestations"> --}}
    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
        <thead>
            <tr>
                <th>N°</th>
                <th>Prestation</th>
                <th>Voiture</th>
                <th>Montant</th>
                <th>Client</th>
                <th>Bénéficiaire</th>
                <th>Charges</th>
                <th>Statut</th>
                <th>Action </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prestations as $prestation)
                <tr>
                    <td> <span class="text-primary">{{ $prestation->numero }}</span></td>
                    <td>{{ $prestation?->produit?->nom }}</td>
                    <td><span class="text-danger"> {{ $prestation?->voiture?->nom }} </span> </td>
                    <td>{{ number_format($prestation->montant_ttc, 2, ',', ' ') }} €</td>
                    <td>
                        @if ($prestation->client()->type == 'individu')
                            {{ $prestation->client()?->individu->nom }} {{ $prestation->client()?->individu->prenom }}
                        @else
                            {{ $prestation->client()?->entite->nom }}
                        @endif


                    </td>
                    <td> {{ $prestation->beneficiaire()->individu->nom }}
                        {{ $prestation->beneficiaire()->individu->prenom }}</td>
                    <td>{{ number_format($prestation->montantCharges(), 2, ',', ' ') }} €</td>
                    <td>
                        @if ($prestation->statut == 'Confirmé')
                            <span class="text-primary">{{ $prestation->statut }} </span>
                        @else
                            <span class="text-default"> {{ $prestation->statut }}</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('prestation.edit', [Crypt::encrypt($prestation->id), $evenement->id]) }}"
                            class="btn btn-primary btn-sm"><i class="mdi mdi-square-edit-outline"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
