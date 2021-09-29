<script>
    $(document).ready(function () {
        var success = "{{Session::get('success')}}";
        var error = "{{Session::get('error')}}";
        var info = "{{Session::get('info')}}";
        if (error != '') {
            Swal.fire({
                title: "Oops!",
                text: error,
                type: "error",
                confirmButtonClass: 'btn btn-primary',
                buttonsStyling: false,
            });
        }
        if (success != '') {
            Swal.fire({
                title: "Good job!",
                text: success,
                type: "success",
                confirmButtonClass: 'btn btn-primary',
                buttonsStyling: false,
            });
        }
        if (info != '') {
            Swal.fire({
                title: "Oops!",
                text: info,
                type: "info",
                confirmButtonClass: 'btn btn-primary',
                buttonsStyling: false,
            });
        }
    });
</script>