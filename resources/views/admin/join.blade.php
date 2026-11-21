<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Make your login — Ajax back office</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="admin-body">
<div class="auth-wrap">
    <div class="admin-login-box">
        <div class="admin-brand">@include('admin.partials.brand')</div>
        <h1>Make your login</h1>
        <p class="muted" style="margin:0 0 6px;font-size:14px">Type the code you got, then choose your own e-mail and password. The code works once.</p>
        @if ($errors->any())
            <ul class="form-error">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        @endif
        <form method="POST" action="{{ route('admin.join') }}">
            @csrf
            <label for="code">Code</label>
            <input class="code-input" type="text" id="code" name="code" value="{{ old('code') }}" placeholder="AJX-XXXX-XXXX" autocomplete="off" required autofocus>
            <label for="name">Your name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" autocomplete="name" required>
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="username" required>
            <label for="password">Password <span class="muted" style="font-weight:500">(at least 10 characters)</span></label>
            <input type="password" id="password" name="password" autocomplete="new-password" minlength="10" required>
            <label for="password_confirmation">Password again</label>
            <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" minlength="10" required>
            <button type="submit" class="btn">Make my login</button>
        </form>
        <p class="small">Already have a login? <a href="{{ route('admin.login') }}">Log in</a>.</p>
    </div>
</div>
</body>
</html>
