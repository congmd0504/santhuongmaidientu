<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> @yield('title') </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="vi" />
    <meta name="keywords" content="@yield('keywords')" />
    <meta name="description" content="@yield('description')" />
    <meta name="abstract" content="@yield('abstract')" />
    <meta name="ROBOTS" content="Metaflow" />
    <meta name="ROBOTS" content="noindex, nofollow, all" />
    <meta name="AUTHOR" content="Phan văn tân" />
    <meta name="revisit-after" content="1 days" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta property="og:image" content="@yield('image')" />
    <meta property="og:url" content="{{ makeLink("home") }}" />
    <link rel="canonical" href="{{ makeLink("home") }}" />
    <link rel="shortcut icon" href="../favicon.ico" />
    <!--
    <link rel="stylesheet" href="{linkhost}/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{linkhost}/css/lightbox.min.css" type="text/css" />
    <link rel="stylesheet" href="{linkhost}/css/animate.css" type="text/css" />
    <link href="{linkhost}/css/slick.css" rel="stylesheet" />
    <link href="{linkhost}/css/slick-theme.css" rel="stylesheet" />
    <link rel="stylesheet" href="{linkhost}/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    -->

    <!--
    <link rel="stylesheet" href="{linkhost}/css/stylesheet-2.css" type="text/css" />
    <link rel="stylesheet" href="{linkhost}/css/header.css" type="text/css" />
    <link rel="stylesheet" href="{linkhost}/css/footer.css" type="text/css" />
    <link rel="stylesheet" href="{linkhost}/css/cart.css" type="text/css" />
    -->


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/bootstrap-4.5.3-dist/css/bootstrap.min.css') }}">

    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('font/fontawesome-5.13.1/css/all.min.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('font/fontawesome-5.13.1/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/wow/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/slick-1.8.1/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/slick-1.8.1/css/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/lightbox-plus/css/lightbox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/reset.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/stylesheet.css') }}">

    @yield('css')

</head>

<body class="template-search">
    <div class="wrapper home">


        <div class="wrap-profile-container">
            <div class="container">
                <div class="row">

                    <div class="col-sm-12">
                        @yield('content')
                    </div>
                </div>
            </div>

        </div>



    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script type="text/javascript" src="{{ asset('lib/jquery/jquery-3.2.1.min.js') }} "></script>

    <script type="text/javascript" src="{{ asset('lib/lightbox-plus/js/lightbox-plus-jquery.min.js') }}"></script>

    <!-- Bootstrap 4 -->
    <script type="text/javascript" src="{{ asset('lib/bootstrap-4.5.3-dist/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/wow/js/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/slick-1.8.1/js/slick.min.js') }}"></script>
    <script src="{{asset('lib/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="{{ asset('lib/components/js/Cart.js') }}"></script>
    @yield('js')
</body>

</html>
