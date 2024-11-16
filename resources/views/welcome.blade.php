<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        body {
            background-color: black;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .button {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>
<h1>Welcome {{ $username ?? 'Guest' }}</h1>
@if(Auth::check())
    <form class="button" action="{{ route('logout') }}" method="GET">
        @csrf
        <button type="submit">Logout</button>
    </form>
@else
    <a class="button" href="{{ route('login') }}">
        <button type="button">Login</button>
    </a>
@endif
</body>
</html>
