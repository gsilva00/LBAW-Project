<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <!-- Metadata -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF Token No clue if needed it was on layout.app -->
        <!-- Styles -->
        <title>
            @hasSection('title')
                @yield('title') - {{ config('app.name', 'Laravel') }}
            @else
                {{ config('app.name', 'Laravel') }}
            @endif
        </title>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link href="{{ url('css/userfeed.css') }}" rel="stylesheet">
        <link href="{{ url('css/comments.css') }}" rel="stylesheet">
        <link href="{{ url('css/header.css') }}" rel="stylesheet">
        <link href="{{ url('css/footer.css') }}" rel="stylesheet">
        <link href="{{ url('css/login.css') }}" rel="stylesheet">
        <link href="{{ url('css/recentnews.css') }}" rel="stylesheet">
        <link href="{{ url('css/trendingtag.css') }}" rel="stylesheet">
        <link href="{{ url('css/articlepage.css') }}" rel="stylesheet">
        <link href="{{ url('css/contacts.css') }}" rel="stylesheet">
        <link href="{{ url('css/profile.css') }}" rel="stylesheet">
        <link href="{{ url('css/filter.css') }}" rel="stylesheet">
        <link href="{{ url('css/popup.css') }}" rel="stylesheet">
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        <!-- Scripts -->
        <script src="{{ url('js/dropdown.js') }}" defer> </script>
        <script src="{{ url('js/searchdropdown.js') }}" defer> </script>
        <script src="{{ url('js/filterdropdowntag.js') }}" defer> </script>
        <script src="{{ url('js/filterdropdowntopic.js') }}" defer> </script>
        <script src="{{ url('js/adminpanel.js') }}" defer></script>
        <script src="{{ url('js/userfeed.js') }}" defer></script>
        <script src="{{ url('js/popup.js') }}" defer> </script>
        <script src="{{ url('js/articlepage.js') }}" defer></script>
        <script src="{{ url('js/replies.js') }}" defer> </script>
        <script src="{{ url('js/unfollowtag.js') }}" defer> </script>
        <script src="{{ url('js/unfollowtopic.js') }}" defer> </script>
        <script src="{{ url('js/articlevote.js') }}" defer> </script>
    </head>
    <body>
        <div class="wrapper">
            @include('layouts.header')
            <main class="content">
                @yield('content')
            </main>
            @include('layouts.footer')
        </div>
    </body>
</html>