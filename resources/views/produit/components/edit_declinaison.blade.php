<div class="row">
    <div class="col-lg-11">



        <div class="col-lg-12">

            <div class="table-responsive">
                <table class="table table-centered table-borderless table-hover w-100 dt-responsive " id="tab1">
                    <thead class="table-light">
                        <tr>

                            <th>Déclinaisons</th>
                            <th>Prix d'achat HT</th>
                            <th>Prix d'achat TTC</th>
                            <th>Prix de vente HT</th>
                            <th>Prix de vente TTC</th>
                            <th>Statut</th>
                            <th>Stock</th>
                            <th style="width: 125px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produit->declinaisons() as $proddecli)
                            <tr>
                                <td>

                                    @foreach ($proddecli->valeurcaracteristiques as $key => $valeurcaracteristique)
                                        <span
                                            class="text-body fw-bold">{{ $valeurcaracteristique->caracteristique?->nom }}
                                        </span>
                                        - <span class="text-body"> {{ $valeurcaracteristique->nom }} </span>
                                        @if ($key < count($proddecli->valeurcaracteristiques) - 1)
                                            /
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <a href="#" class="text-body fw-bold">{{ $proddecli->prix_achat_ht }}</a>
                                </td>
                                <td>
                                    <a href="#" class="text-body fw-bold">{{ $proddecli->prix_achat_ttc }}</a>
                                </td>
                                <td>
                                    <a href="#" class="text-body fw-bold">{{ $proddecli->prix_vente_ht }}</a>
                                </td>
                                <td>
                                    <a href="#" class="text-body fw-bold">{{ $proddecli->prix_vente_ttc }}</a>
                                </td>


                                <td>
                                    @if ($proddecli->archive == false)
                                        <span class="badge bg-success">Actif</span>
                                    @else
                                        <span class="badge bg-warning">Archivé</span>
                                    @endif
                                </td>

                                <td>

                                    @if ($proddecli->gerer_stock)
                                        <span class="fw-bold"> {{ $proddecli->stock->quantite }}</span>
                                    @else
                                        <span class="fst-italic">non géré</span>
                                    @endif


                                </td>


                                <td>


                                    <a data-href="{{ route('produit_declinaison.update', Crypt::encrypt($proddecli->id)) }}"
                                        data-prix_vente_ht="{{ $proddecli->prix_vente_ht }}"
                                        data-prix_vente_ttc="{{ $proddecli->prix_vente_ttc }}"
                                        data-prix_vente_max_ht="{{ $proddecli->prix_vente_max_ht }}"
                                        data-prix_vente_max_ttc="{{ $proddecli->prix_vente_max_ttc }}"
                                        data-prix_achat_ht="{{ $proddecli->prix_achat_ht }}"
                                        data-prix_achat_ttc="{{ $proddecli->prix_achat_ttc }}"
                                        data-prix_achat_commerciaux_ht="{{ $proddecli->prix_achat_commerciaux_ht }}"
                                        data-prix_achat_commerciaux_ttc="{{ $proddecli->prix_achat_commerciaux_ttc }}"
                                        data-gerer_stock="{{ $proddecli->gerer_stock }}"
                                        data-valeurcaracteristique="{{ $proddecli->valeurcaracteristique_id() }}"
                                        data-produitdecli_id="{{ $proddecli->id }}"
                                        data-quantite="{{ $proddecli->stock?->quantite }}"
                                        data-quantite_min="{{ $proddecli->stock?->quantite_min }}"
                                        data-seuil_alerte="{{ $proddecli->stock?->seuil_alerte }}"
                                        data-bs-toggle="modal" data-bs-target="#edit-declinaison"
                                        class="action-icon edit-declinaison text-success" style="cursor: pointer;">
                                        <i class="mdi mdi-square-edit-outline"></i>
                                    </a>
                                    @if ($proddecli->archive == false)
                                        <a data-href="{{ route('produit_declinaison.archive', Crypt::encrypt($proddecli->id)) }}"
                                            style="cursor: pointer;"
                                            class="action-icon archive-produit-decli text-warning"> <i
                                                class="mdi mdi-archive-arrow-down"></i></a>
                                    @else
                                        <a data-href="{{ route('produit_declinaison.unarchive', Crypt::encrypt($proddecli->id)) }}"
                                            style="cursor: pointer;"
                                            class="action-icon unarchive-produit-decli text-success"> <i
                                                class="mdi mdi-archive-arrow-up"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>


        </div>
    </div>



</div>
