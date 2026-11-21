<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Back office') — Ajax</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="admin-body">
    <div class="admin-shell">
        <nav class="admin-nav">
            <a class="admin-brand" href="{{ route('admin.texts.index') }}">@include('admin.partials.brand')</a>
            <a class="nav @if(request()->routeIs('admin.texts.*')) is-active @endif" href="{{ route('admin.texts.index') }}">Website texts</a>
            <a class="nav @if(request()->routeIs('admin.portfolio.*')) is-active @endif" href="{{ route('admin.portfolio.index') }}">Projects</a>
            <a class="nav @if(request()->routeIs('admin.design.*')) is-active @endif" href="{{ route('admin.design.index') }}">Design pictures</a>
            @can('owner')
                <a class="nav @if(request()->routeIs('admin.team.*')) is-active @endif" href="{{ route('admin.team.index') }}">Team &amp; login codes</a>
            @endcan
            <div class="nav-sep"></div>
            <a class="nav" href="{{ route('home') }}" target="_blank" rel="noopener">Open website ↗</a>
            <div class="admin-user"><b>{{ auth()->user()->name }}</b>{{ auth()->user()->role }}</div>
            <form method="POST" action="{{ route('admin.logout') }}" class="admin-logout">
                @csrf
                <button type="submit">Log out</button>
            </form>
        </nav>
        <main class="admin-main">
            @if (session('status'))
                <p class="form-success" role="status">{{ session('status') }}</p>
            @endif
            @if ($errors->any())
                <ul class="form-error">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
