<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Ajax Trading Corp. - Property Business">
        <meta name="keywords" content="Ajax Trading Corp." />
        <meta name="author" content="Maria Christine Joy R. Salamat">
        <title>@yield('page_title')</title>

        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @auth<meta name="uid" content="{{Auth::user()->id}}" />@endauth

        <meta property="og:title" content="Ajax Trading Corp.">
        <meta property="og:description" content="Ajax Trading Corp. - Property Business">
        <meta property="og:image" content="/assets/images/logos/logo.png">


        <link rel="icon" type="image/x-icon" href="{{$icon ?? 'assets/images/icons/icon.png'}}">

        <meta name="theme-color" content="#3454d1">
        <link href="{{ asset('assets/css') }}/toastr.min.css?1.4" rel="stylesheet">
        <link href="{{ asset('assets/css') }}/styles.css?1.5" rel="stylesheet">
        <link href="{{ asset('assets/css') }}/custom.css?1.9" rel="stylesheet">
        <link href="{{ asset('assets/css') }}/cart.css?0.1" rel="stylesheet">
        <link href="{{ asset('assets/css') }}/preloader.css" rel="stylesheet">
        <link href="{{ asset('assets/css') }}/cart.css?0.1" rel="stylesheet">
        <link href="{{ asset('assets/css') }}/colors.css" rel="stylesheet">
        <script type="text/javascript" src="{{ asset('assets/js') }}/js_cookie.js"></script>
        <link href="{{ asset('assets/css/additional') }}/navbar.css" rel="stylesheet">
        <link href="{{ asset('assets/css') }}/chat.css" rel="stylesheet">
        @yield('page_css')
    </head>

    <!-- <body style="background-image: url('/assets/images/covers/bg.jpg');"> -->
    <body>
        <header class="{{ isset($header_class)?$header_class:'' }}">
            @include('front-ends.layouts.navbar')
            @yield('intro_section')
        </header>
        @yield('main_content')
        @include('chats.chat-modal')
        @include('front-ends.layouts.footer')


        <!-- END SCROLL TO TOP -->
        <script src="{{ asset('assets/js') }}/index.bundle.js?fd365619e86ad9137a29"></script>
        <script type="text/javascript" src="{{ asset('assets/js') }}/bootstrap/bootstrap.min.js"></script>
        <script src="{{ asset('assets/js') }}/jquery-ui/jquery-ui.js"></script>
        <script type="text/javascript" src="{{ asset('assets/js') }}/socket.io/socket.io.min.js"></script>
        <script src="{{ asset('assets/js') }}/toastr.min.js"></script>
        <script src="{{ asset('assets/js') }}/sweetalert2.js"></script>
        <script src="{{ asset('assets/js') }}/alert.js"></script>
        <script type="text/javascript" src="/assets/js/globalfunction.js?v=2.0"></script>
        <script type="text/javascript" src="/js/chats/chat.js" ></script>
        @yield('page_js')
    </body>

</html>
