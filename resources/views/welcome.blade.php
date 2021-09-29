@extends('layouts.front')

@section('title', config('rcc.type'))

@section('content')

    <div class="form-section rgba-stylish-strong h-100 d-flex justify-content-center align-items-center" style="height: 100% !important;">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-10 col-sm-12 mx-auto">
                    <!--Form with header-->
                    <div class="card wow fadeIn login-card" data-wow-delay="0.3s">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="username" class="form-label">User name</label>
                                <input type="text" id="username" name="username" class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control" />
                            </div>
                            <button type="button" id="submit-user" class="btn btn-success">Sign in</button>
                        </div>
                    </div>
                    <!--/Form with header-->
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            var success = "{{Session::get('success')}}";
            var error = "{{Session::get('error')}}";
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
        });

        !function(e){navigator.userAgent.toLowerCase().indexOf("chrome")>=0&&e("input, select").on("change focus",function(t){setTimeout(function(){e.each(document.querySelectorAll("*:-webkit-autofill"),function(){var t=e(this).clone(!0,!0);e(this).after(t).remove(),n()})},300)}).change();var n=function(){};n()}(jQuery);
        
        $('#password').keypress(function (e) {
            if (e.which == 13) {
                $('#submit-user').trigger( "click" );
                return false;    // same as calling e.preventDefault and e.stopPropagation
            }
        });

        $("#submit-user").click(function(e) {
            if ( $("#username").val().length !== 0 && $("#password").val().length !== 0 ){
                var username = $('#username').val();
                var password = $('#password').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{url("/authentication")}}',
                    type: 'POST',
                    data: {
                        username:username,
                        password:password
                    },
                    dataType: 'JSON',
                    success: function (data) { 
                        if(data.result == true) {
                            console.log(data);
                            window.location.href = '{{ route("admin") }}';
                        }
                        else {
                            swal("Opps !", data.message, "error");
                        }                      
                    }
                });
            }
            else {
                swal("Opps !", "Please enter username and password", "error");
            }
        });

    </script>
@endsection
