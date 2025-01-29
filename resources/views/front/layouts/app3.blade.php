<!doctype html>
<html class="no-js" lang="en">

<!-- Mirrored from new.axilthemes.com/demo/template/etrade/sign-up.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 14 Jul 2024 14:43:36 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset(webData()->favicon) }}">

    <!-- CSS
    ============================================ -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/vendor/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/vendor/flaticon/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/vendor/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/vendor/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/vendor/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/vendor/sal.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/vendor/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/vendor/base.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/css/custom.css') }}">

</head>

<body>
    <div id="preloader"></div>

    @yield('content')

    <!-- JS
============================================ -->
    <!-- Modernizer JS -->
    <script src="{{ asset('front-assets/js/vendor/modernizr.min.js') }}"></script>
    <!-- jQuery JS -->
    <script src="{{ asset('front-assets/js/vendor/jquery.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('front-assets/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/slick.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/js.cookie.js') }}"></script>
    <!-- <script src="{{ asset('front-assets/js/vendor/jquery.style.switcher.js') }}"></script> -->
    <script src="{{ asset('front-assets/js/vendor/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/jquery.ui.touch-punch.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/sal.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/counterup.js') }}"></script>
    <script src="{{ asset('front-assets/js/vendor/waypoints.min.js') }}"></script>


    <!-- Main JS -->
    <script src="{{ asset('front-assets/js/main.js') }}"></script>
    <script src="{{ asset('front-assets/js/custom.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script
        src="https://www.paypal.com/sdk/js?client-id=AfOMyE9PzwZDd1uJDzex9zTV71o1Sbf_5Uu9sIw2cN-oXaLV9suCHptG7boZs4UhvSaIsfBxvgleDN2u&buyer-country=US&currency=USD&components=buttons&enable-funding=venmo,paylater,card"
        data-sdk-integration-source="developer-studio"></script>

    @yield('customJs')
    @include('sweetalert::alert')
</body>

<!-- Mirrored from new.axilthemes.com/demo/template/etrade/sign-up.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 14 Jul 2024 14:43:36 GMT -->

</html>