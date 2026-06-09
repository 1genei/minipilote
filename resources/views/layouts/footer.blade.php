<!-- Footer Start -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <script>
                    document.write(new Date().getFullYear())
                </script> © {{ env('APP_NAME') }}
            </div>
            <div class="col-md-6">
                <div class="text-md-end footer-links d-none d-md-block">
                    {{-- <a href="javascript: void(0);">About</a>
                    <a href="javascript: void(0);">Support</a>
                    <a href="javascript: void(0);">Contact Us</a> --}}
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end Footer -->

</div> <!-- content-page -->

</div> <!-- end wrapper-->
</div>
<!-- END Container -->



<div class="rightbar-overlay"></div>
<!-- /End-bar -->

<!-- Alpine.js v3 — chargé avant Livewire pour que window.Alpine soit disponible -->
<script src="{{ asset('assets/js/alpine.min.js') }}"></script>

@livewireScripts

<!-- bundle -->
<script src="{{ asset('assets/js/sweetalert2.all.js') }}"></script>

<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>

@yield('script')

</body>

</html>
