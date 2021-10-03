<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- base url for scripts -->
    <script>
        var APP_URL = "{{url('/')}}";
    </script>

    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fonts/circularStd/index.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/css/style-front.css') }}">

    <title>{{ config('sfa.short_name') }} | @yield('title')</title>

</head>

<body style="height: inherit !important;">
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->

    @yield('content')

    <div class="footer_div">
        <div class="title">
            {{ config('sfa.type') }}
        </div>
        <div class="sub_title">
            {{ config('sfa.name') }}
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->

    <!-- Optional JavaScript -->
    <script src="{{ asset('vendor/jquery/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert2.all.min.js') }}"></script>

    @include('includes.sweetalert')

    @yield('js')

</body>

</html>
