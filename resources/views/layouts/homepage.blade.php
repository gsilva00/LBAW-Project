<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
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
<header>
    <h1>{{ config('app.name', 'Laravel') }}</h1>
</header>
<main>
    @yield('content')
</main>
</body>
</html>