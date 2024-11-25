<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <!-- CSRF Token No clue if needed it was on layout.app -->
         <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <script src="{{ url('js/dropdown.js') }}" defer> </script>
        <script src="{{ url('js/searchdropdown.js') }}" defer> </script>
        <script src="{{ url('js/filterdropdowntag.js') }}" defer> </script>
        <script src="{{ url('js/filterdropdowntopic.js') }}" defer> </script>
        <script src="{{ url('js/adminpanel.js') }}" defer></script>
        <script src="{{ url('js/userfeed.js') }}" defer></script>
        <script src="{{ url('js/tagcreatearticle.js') }}"> </script>
        <link href="{{ url('css/userfeed.css') }}" rel="stylesheet">
        <link href="{{ url('css/header.css') }}" rel="stylesheet">
        <link href="{{ url('css/footer.css') }}" rel="stylesheet">
        <link href="{{ url('css/login.css') }}" rel="stylesheet">
        <link href="{{ url('css/recentnews.css') }}" rel="stylesheet">
        <link href="{{ url('css/trendingtag.css') }}" rel="stylesheet">
        <link href="{{ url('css/articlepage.css') }}" rel="stylesheet">
        <link href="{{ url('css/contacts.css') }}" rel="stylesheet">
        <link href="{{ url('css/profile.css') }}" rel="stylesheet">
        <link href="{{ url('css/filter.css') }}" rel="stylesheet">
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="wrapper">
            @include('pages.header')
            <main class="content">
                @yield('content')
            </main>
            @include('pages.footer')
        </div>
    </body>
</html>