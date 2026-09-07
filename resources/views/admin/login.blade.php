<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin login — Ajax Trading Corporation</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-body">
    <div class="admin-login-box">
        <h1>Admin login</h1>
        @if ($errors->any())
            <p class="form-error">{{ $errors->first() }}</p>
        @endif
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required autofocus>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label class="checkbox-label"><input type="checkbox" name="remember"> Remember me</label>

            <button type="submit">Log in</button>
        </form>
    </div>
</body>
</html>
