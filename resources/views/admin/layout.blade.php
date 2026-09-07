<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin') — Ajax Trading Corporation</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-body">
    <div class="admin-shell">
        <nav class="admin-nav">
            <p class="admin-brand">Ajax admin</p>
            <a href="{{ route('admin.portfolio.index') }}">Portfolio</a>
            <a href="{{ route('admin.products.index') }}">Products</a>
            <a href="{{ route('admin.showrooms.index') }}">Showrooms</a>
            <a href="{{ route('admin.highlights.index') }}">Highlights</a>
            <form method="POST" action="{{ route('admin.logout') }}" class="admin-logout">
                @csrf
                <button type="submit">Log out</button>
            </form>
        </nav>
        <main class="admin-main">
            @if (session('status'))
                <p class="form-success">{{ session('status') }}</p>
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
