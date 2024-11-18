<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="{{ url('js/dropdown.js') }}"> </script>
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <link href="{{ url('css/header.css') }}" rel="stylesheet">
    <link href="{{ url('css/footer.css') }}" rel="stylesheet">

    <link href="{{ url('css/contacts.css') }}" rel="stylesheet">
    <!--  <link href="{{ url('css/app.css') }}" rel="stylesheet"> -->
</head>
<body>
    @include('pages.header')
<main>
    @yield('content')
</main>
    @include('pages.footer')
</body>
</html>