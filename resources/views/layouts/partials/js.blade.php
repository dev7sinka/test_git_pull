<script src="{{ asset('assets/vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendors/simplebar/js/simplebar.min.js') }}"></script>
<!-- CoreUI and necessary plugins-->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $(".alert").alert('close');
        }, 5000);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            cache: false
        });

        $(document).on("ajaxStop", function(){
            $("#spinner").hide();
            $(".overlay").remove();
        });

        $(document).on("ajaxStart", function(){
            $("#spinner").show();
            $("body").append("<div class='overlay'></div>");
        });
    })
</script>
@yield('script_js')
