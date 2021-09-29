<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- base URL -->
    <script>
        var BASE_URL = "{{config('rcc.base_url')}}";
    </script>

    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}">

    <!--fonts and icons-->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/fontawesome-all.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fonts/circularStd/index.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/jquery/css/jquery-confirm.min.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/jquery/css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('libs/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/css/custom-layout.css')}}">

    @yield('css')

    @yield('head-scripts')

    <title>{{ config('sfa.short_name') }} | @yield('title')</title>

</head>
<body>
    <div class="wrapper">
        
        <!--top navbar-->
        @yield('navbar')
        <!--end of top navbar-->

        <!-- main body (sidebar and content) -->
        <div class="main-body open-sidebar" id="main-body">

            <!-- content -->
            @yield('content')
            <!-- end of content -->

        </div>
        <!-- end of main body (sidebar and content) -->

        <!--top footer-->
        @yield('footer')
        <!--end of footer-->

    </div>

    <!--sidebar-->
    @yield('sidebar')
    <!--end of sidebar-->

    <!-- Optional JavaScript -->
    <script src="{{ asset('vendor/jquery/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('libs/js/custom-script.js')}}"></script>

    @include('includes.sweetalert')

    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
    
    @yield('script')

</body>
</html>
