<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/dashboard') }}/images/favicon.ico">

    <!-- jsvectormap css -->
    <link href="{{ asset('assets/dashboard') }}/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('assets/dashboard') }}/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="{{ asset('assets/dashboard') }}/js/layout.js"></script>
    
    {{-- RTL FILES --}}
    @if (LaravelLocalization::getCurrentLocaleDirection() == 'rtl')
        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/dashboard') }}/css/bootstrap-rtl.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/dashboard') }}/css/app-rtl.min.css" id="app-style" rel="stylesheet" type="text/css" />
    @else
        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/dashboard') }}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/dashboard') }}/css/app.min.css" rel="stylesheet" type="text/css" />
    @endif

    <!-- Icons Css -->
    <link href="{{ asset('assets/dashboard') }}/css/icons.min.css" rel="stylesheet" type="text/css" />

    {{-- Sweet Alert --}}
    <link rel="stylesheet" href="{{ asset('assets/dashboard/libs/sweetalert2/sweetalert2.min.css') }}">
    <!-- custom Css-->
    <link href="{{ asset('assets/dashboard') }}/css/custom.min.css" rel="stylesheet" type="text/css" />
</head>