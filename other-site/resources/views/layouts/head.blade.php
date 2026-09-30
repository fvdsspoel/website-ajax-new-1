<head>
    <title>{{$title}}</title>
    <link rel="icon" href="{{ asset('assets/images/icons/icon.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css') }}/web.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css') }}/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="{{ asset('assets/css') }}/animate/animate.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css') }}/colors.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css') }}/add.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css') }}/jquery-ui/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css') }}/swal/swal.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css') }}/sidenav.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css') }}/custom.css?v=1.8">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css') }}/new-site.css?v=1.5">
    <link href="{{ asset('assets/css') }}/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css') }}/sidenav.css">

    <link href="{{ asset('assets/css') }}/call_request.css" rel="stylesheet">

    @yield('styles')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @auth<meta name="uid" content="{{Auth::user()->id}}" />@endauth

    @yield('scripts')
    <script type="text/javascript" src="{{ asset('assets/js') }}/jquery/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js') }}/popper/popper.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js') }}/bootstrap/bootstrap.min.js"></script>
    <script src="{{ asset('assets/js') }}/jquery-ui/jquery-ui.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js') }}/socket.io/socket.io.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js') }}/swal/swal.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js') }}/global_functions.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js') }}/new-site.js"></script>

    <script src="{{ asset('assets/js') }}/manifest.js"></script> <!-- Laravel Webpack Manifest -->
    <script src="{{ asset('assets/js') }}/sweetalert.min.js"></script> <!-- Laravel Webpack Manifest -->
    <script src="{{ asset('assets/js') }}/helper.js"></script> <!-- Helper Scripts -->
    <script src="{{ asset('assets/js') }}/common.js"></script> <!-- Helper Scripts -->
    <script src="{{ asset('assets/js') }}/toastr.min.js"></script>
</head>
