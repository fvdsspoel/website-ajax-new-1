<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Ajax Trading Corp. - Property Business">
    <meta name="keywords" content="Ajax Trading Corporation." />
    <meta name="author" content="Maria Christine Joy R. Salamat">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{$title ?? 'AJAX TRADING CORP.'}}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images') }}/icons/icon.png">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap/bootstrap.css">
    <link href="{{ asset('assets/css') }}/navbar.css" rel="stylesheet">
    <link href="{{ asset('assets/css') }}/custom.css" rel="stylesheet">
    @yield('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm border-buttom">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="navbar-logo hide-mobile show-pc" src="/assets/images/logos/logo.png">
                    <img class="mnavbar-logo show-mobile hide-pc" src="/assets/images/logos/logo.png">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mx-auto justify-content-center">

                        <li class="nav-item">
                            <a class="nav-link bold-text black-text nav-li-padding" href="{{ route('home') }}">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link bold-text black-text nav-li-padding" href="{{ route('login') }}">ABOUT US</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link bold-text black-text nav-li-padding" href="{{ route('login') }}">PRODUCTS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link bold-text black-text nav-li-padding" href="{{ route('login') }}">BUY & BUILD</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link bold-text black-text nav-li-padding" href="{{ route('login') }}">CONTACT US</a>
                        </li>
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link bold-text black-text" href="{{ route('login') }}">LOGIN</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link bold-text black-text" href="{{ route('register') }}">REGISTER</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
