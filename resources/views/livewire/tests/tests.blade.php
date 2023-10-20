<div class="content-page">
    <div class="content">


        <div class="row">

            <!-- Right Sidebar -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Left sidebar -->
                        <div class="page-aside-left">

                            <div class="d-grid">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#compose-modal">Compose</button>
                            </div>




                            <div class="mt-4" data-simplebar style="max-height: 250px;">
                                <h6 class="text-uppercase">Produits</h6>
                                <div class="email-menu-list labels-list mt-2">
                                    @foreach ($produits as $produit)
                                        <div wire:key="{{ $produit->id }}">
                                            @if ($produit->type == 'simple')
                                                <a href="javascript: void(0);"
                                                    wire:click="afficher_produit({{ $produit->id }})">
                                                    <i
                                                        class="mdi mdi-circle font-13 text-secondary me-2"></i>{{ $produit->nom }}</a>
                                            @else
                                                <a href="javascript: void(0);"
                                                    wire:click="afficher_produit({{ $produit->id }})"><i
                                                        class="mdi mdi-circle font-13 text-success me-2"></i>{{ $produit->nom }}</a>
                                            @endif
                                        </div>
                                    @endforeach



                                </div>
                            </div>



                        </div>
                        <!-- End Left sidebar -->

                        <div class="page-aside-right">

                            <div class="mt-3">
                                <h5 class="font-18">{{ $titre }}</h5>

                                <hr />
                                <p>
                                    {!! $description !!}
                                </p>

                                <hr />
                                <!-- end row-->



                                {{ $produits->links() }}

                                <div class="mt-5">
                                    <a href="" class="btn btn-secondary me-2"><i class="mdi mdi-reply me-1"></i>
                                        Reply</a>
                                    <a href="" class="btn btn-light">Forward <i
                                            class="mdi mdi-forward ms-1"></i></a>
                                </div>

                            </div>
                            <!-- end .mt-4 -->

                        </div>
                        <!-- end inbox-rightbar-->
                    </div>

                    <div class="clearfix"></div>
                </div> <!-- end card-box -->

            </div> <!-- end Col -->
        </div><!-- End row -->



    </div> <!-- End Content -->



</div> <!-- content-page -->
