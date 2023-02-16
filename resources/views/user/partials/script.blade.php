<script src="{{ asset('assets/js/user/sweetalert2.all.js') }}"></script>
<script src="{{ asset('assets/js/user/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/user/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/user/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/user/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/user/toastr.min.js') }}"></script>
<script src="{{ asset('assets/js/user/jquery.mask.min.js') }}"></script>
<script src="{{ asset('assets/js/user/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/user/bootstrap.min.js') }}"></script>

@vite([
    'resources/assets/js/jquery.min.js',
])
@stack('script_vendor')
@stack('script')
<script>
    @if(Session::has('success'))
        toastr.options = {
            "closeButton" : false,
            "progressBar" : false,
            "fadeOut" : 300,
            "timeOut" : 6000,
            "extendedTimeOut" : 6000,
        }
        toastr.success("{{ session('success') }}");
    @endif

    @if(Session::has('info'))
        toastr.options = {
            "closeButton" : false,
            "progressBar" : false,
            "fadeOut" : 300,
            "timeOut" : 6000,
            "extendedTimeOut" : 6000,
        }
        toastr.info("{{ session('info') }}");
    @endif

    @if(Session::has('warning'))
        toastr.options = {
            "closeButton" : false,
            "progressBar" : false,
            "fadeOut" : 300,
            "timeOut" : 6000,
            "extendedTimeOut" : 6000,
        }
        toastr.warning("{{ session('warning') }}");
    @endif

        @if(Session::has('error'))
        toastr.options = {
            "closeButton" : false,
            "progressBar" : false,
            "fadeOut" : 300,
            "timeOut" : 6000,
            "extendedTimeOut" : 6000,
        }
        toastr.error("{{ session('error') }}");
    @endif
</script>
