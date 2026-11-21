<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Log in — Ajax back office</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="admin-body">
<div class="auth-wrap">
    <div class="admin-login-box">
        <div class="admin-brand">@include('admin.partials.brand')</div>
        <h1>Log in</h1>
        @if ($errors->any())
            <p class="form-error">{{ $errors->first() }}</p>
        @endif
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" autocomplete="current-password" required>
            <label class="checkbox-label" style="font-weight:500"><input type="checkbox" name="remember" style="width:auto"> Keep me logged in</label>
            <button type="submit" class="btn">Log in</button>
        </form>
        <p class="small">New here and got a code? <a href="{{ route('admin.join') }}">Make your login with the code</a>.</p>
    </div>
</div>
</body>
</html>
