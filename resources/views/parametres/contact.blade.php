@extends('layouts.app')
@section('css')
@endsection

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="">Paramètres</a></li>
                            {{-- <li class="breadcrumb-item active">Détails</li> --}}
                        </ol>
                    </div>
                    <h4 class="page-title">Paramètres</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->



        <!-- end row-->


        <div class="row">
            <div class="col-lg-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-sm-4  mr-14 ">
                                {{-- <a href="{{route('action.index')}}" type="button" class="btn btn-outline-primary"><i class="uil-arrow-left"></i> Retour</a> --}}
                                <h4 class="modal-title" id="addActionModalLabel"> Modification de vos paramètres </h4>

                            </div>
                            @if (session('ok'))
                                <div class="col-6">
                                    <div class="alert alert-success alert-dismissible bg-success text-white text-center border-0 fade show"
                                        role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong> {{ session('ok') }}</strong>
                                    </div>
                                </div>
                            @endif

                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card-box-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->
        <div class="row">



            <div class="col-12 ">
                <div class="card">
                    <div class="card-body">

                        <!-- Checkout Steps -->
                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#billing-information" data-bs-toggle="tab" aria-expanded="false"
                                    class="nav-link rounded-0 active">
                                    <i class="mdi mdi-account-circle font-18"></i>
                                    <span class="d-none d-lg-block">Type des contacts</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#shipping-information" data-bs-toggle="tab" aria-expanded="true"
                                    class="nav-link rounded-0">
                                    <i class="mdi mdi-truck-fast font-18"></i>
                                    <span class="d-none d-lg-block">Postes</span>
                                </a>
                            </li>

                        </ul>

                        <!-- Steps Information -->
                        <div class="tab-content">

                            <!-- Billing Content-->
                            <div class="tab-pane show active" id="billing-information">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h4 class="mt-2">Billing information</h4>

                                        <p class="text-muted mb-4">Fill the form below in order to
                                            send you the order's invoice.</p>

                                        <form>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="billing-first-name" class="form-label">First
                                                            Name</label>
                                                        <input class="form-control" type="text"
                                                            placeholder="Enter your first name" id="billing-first-name" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="billing-last-name" class="form-label">Last Name</label>
                                                        <input class="form-control" type="text"
                                                            placeholder="Enter your last name" id="billing-last-name" />
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="billing-email-address" class="form-label">Email Address
                                                            <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="email"
                                                            placeholder="Enter your email" id="billing-email-address" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="billing-phone" class="form-label">Phone <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" type="text"
                                                            placeholder="(xx) xxx xxxx xxx" id="billing-phone" />
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label for="billing-address" class="form-label">Address</label>
                                                        <input class="form-control" type="text"
                                                            placeholder="Enter full address" id="billing-address">
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="billing-town-city" class="form-label">Town /
                                                            City</label>
                                                        <input class="form-control" type="text"
                                                            placeholder="Enter your city name" id="billing-town-city" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="billing-state" class="form-label">State</label>
                                                        <input class="form-control" type="text"
                                                            placeholder="Enter your state" id="billing-state" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="billing-zip-postal" class="form-label">Zip / Postal
                                                            Code</label>
                                                        <input class="form-control" type="text"
                                                            placeholder="Enter your zip code" id="billing-zip-postal" />
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Country</label>
                                                        <select data-toggle="select2" title="Country">
                                                            <option value="0">Select Country</option>
                                                            <option value="AF">Afghanistan</option>
                                                            <option value="AL">Albania</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="customCheck2">
                                                            <label class="form-check-label" for="customCheck2">Ship to
                                                                different address ?</label>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 mt-3">
                                                        <label for="example-textarea" class="form-label">Order
                                                            Notes:</label>
                                                        <textarea class="form-control" id="example-textarea" rows="3" placeholder="Write some note.."></textarea>
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->

                                            <div class="row mt-4">
                                                <div class="col-sm-6">
                                                    <a href="apps-ecommerce-shopping-cart.html"
                                                        class="btn text-muted d-none d-sm-inline-block btn-link fw-semibold">
                                                        <i class="mdi mdi-arrow-left"></i> Back to Shopping Cart </a>
                                                </div> <!-- end col -->
                                                <div class="col-sm-6">
                                                    <div class="text-sm-end">
                                                        <a href="apps-ecommerce-checkout.html" class="btn btn-danger">
                                                            <i class="mdi mdi-truck-fast me-1"></i> Proceed to Shipping
                                                        </a>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->
                                        </form>
                                    </div>

                                </div> <!-- end row-->
                            </div>
                            <!-- End Billing Information Content-->

                            <!-- Shipping Content-->
                            <div class="tab-pane" id="shipping-information">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h4 class="mt-2">Saved Address</h4>

                                        <p class="text-muted mb-3">Fill the form below in order to
                                            send you the order's invoice.</p>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="border p-3 rounded mb-3 mb-md-0">
                                                    <address class="mb-0 address-lg">
                                                        <div class="form-check">
                                                            <input type="radio" id="customRadio1" name="customRadio"
                                                                class="form-check-input" checked>
                                                            <label class="form-check-label font-16 fw-bold"
                                                                for="customRadio1">Home</label>
                                                        </div>
                                                        <br />
                                                        <span class="fw-semibold">Stanley Jones</span> <br />
                                                        795 Folsom Ave, Suite 600<br>
                                                        San Francisco, CA 94107<br>
                                                        <abbr title="Phone">P:</abbr> (123) 456-7890 <br>
                                                    </address>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="border p-3 rounded">
                                                    <address class="mb-0 address-lg">
                                                        <div class="form-check">
                                                            <input type="radio" id="customRadio2" name="customRadio"
                                                                class="form-check-input">
                                                            <label class="form-check-label font-16 fw-bold"
                                                                for="customRadio2">Office</label>
                                                        </div>
                                                        <br />
                                                        <span class="fw-semibold">Stanley Jones</span> <br />
                                                        795 Folsom Ave, Suite 600<br>
                                                        San Francisco, CA 94107<br>
                                                        <abbr title="Phone">P:</abbr> (123) 456-7890 <br>
                                                    </address>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row-->

                                        <h4 class="mt-4">Add New Address</h4>

                                        <p class="text-muted mb-4">Fill the form below so we can
                                            send you the order's invoice.</p>

                                        <form>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="new-adr-first-name" class="form-label">First
                                                            Name</label>
                                                        <input class="form-control" type="text"
                                                            placeholder="Enter your first name" id="new-adr-first-name" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="new-adr-last-name" class="form-label">Last
                                                            Name</label>
                                                        <input class="form-control" type="text"
                                                            placeholder="Enter your last name" id="new-adr-last-name" />
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="new-adr-email-address" class="form-label">Email
                                                            Address <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="email"
                                                            placeholder="Enter your email" id="new-adr-email-address" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="new-adr-phone" class="form-label">Phone <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" type="text"
                                                            placeholder="(xx) xxx xxxx xxx" id="new-adr-phone" />
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label for="new-adr-address" class="form-label">Address</label>
                                                        <input class="form-control" type="text"
                                                            placeholder="Enter full address" id="new-adr-address">
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="new-adr-town-city" class="form-label">Town /
                                                            City</label>
                                                        <input class="form-control" type="text"
                                                            placeholder="Enter your city name" id="new-adr-town-city" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="new-adr-state" class="form-label">State</label>
                                                        <input class="form-control" type="text"
                                                            placeholder="Enter your state" id="new-adr-state" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="new-adr-zip-postal" class="form-label">Zip / Postal
                                                            Code</label>
                                                        <input class="form-control" type="text"
                                                            placeholder="Enter your zip code" id="new-adr-zip-postal" />
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Country</label>
                                                        <select data-toggle="select2" title="Country">
                                                            <option value="0">Select Country</option>
                                                            <option value="AF">Afghanistan</option>
                                                            <option value="AL">Albania</option>
                                                            <option value="DZ">Algeria</option>



                                                            <option value="ZM">Zambia</option>
                                                            <option value="ZW">Zimbabwe</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->

                                            <h4 class="mt-4">Shipping Method</h4>

                                            <p class="text-muted mb-3">Fill the form below in order to
                                                send you the order's invoice.</p>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="border p-3 rounded mb-3 mb-md-0">
                                                        <div class="form-check">
                                                            <input type="radio" id="shippingMethodRadio1"
                                                                name="shippingOptions" class="form-check-input" checked>
                                                            <label class="form-check-label font-16 fw-bold"
                                                                for="shippingMethodRadio1">Standard Delivery - FREE</label>
                                                        </div>
                                                        <p class="mb-0 ps-3 pt-1">Estimated 5-7 days shipping (Duties and
                                                            tax may be due upon delivery)</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="border p-3 rounded">
                                                        <div class="form-check">
                                                            <input type="radio" id="shippingMethodRadio2"
                                                                name="shippingOptions" class="form-check-input">
                                                            <label class="form-check-label font-16 fw-bold"
                                                                for="shippingMethodRadio2">Fast Delivery - $25</label>
                                                        </div>
                                                        <p class="mb-0 ps-3 pt-1">Estimated 1-2 days shipping (Duties and
                                                            tax may be due upon delivery)</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end row-->

                                            <div class="row mt-4">
                                                <div class="col-sm-6">
                                                    <a href="apps-ecommerce-shopping-cart.html"
                                                        class="btn text-muted d-none d-sm-inline-block btn-link fw-semibold">
                                                        <i class="mdi mdi-arrow-left"></i> Back to Shopping Cart </a>
                                                </div> <!-- end col -->
                                                <div class="col-sm-6">
                                                    <div class="text-sm-end">
                                                        <a href="apps-ecommerce-checkout.html" class="btn btn-danger">
                                                            <i class="mdi mdi-cash-multiple me-1"></i> Continue to Payment
                                                        </a>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->
                                        </form>
                                    </div>

                                </div> <!-- end row-->
                            </div>
                            <!-- End Shipping Information Content-->

                        </div>
                        <!-- End Payment Information Content-->

                    </div> <!-- end tab content-->











                </div>
            </div>
        </div> <!-- end col -->




    </div> <!-- end row -->




    </div> <!-- End Content -->
@endsection

@section('script')
@endsection
