<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <!-- Metadata -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF Token No clue if needed it was on layout.app -->
        <title>
            @hasSection('title')
                @yield('title') - {{ config('app.name', 'Laravel') }}
            @else
                {{ config('app.name', 'Laravel') }}
            @endif
        </title>
        <!-- Styles -->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link href="{{ url('css/user_feed.css') }}" rel="stylesheet">
        <link href="{{ url('css/comments.css') }}" rel="stylesheet">
        <link href="{{ url('css/header.css') }}" rel="stylesheet">
        <link href="{{ url('css/footer.css') }}" rel="stylesheet">
        <link href="{{ url('css/login.css') }}" rel="stylesheet">
        <link href="{{ url('css/recent_news.css') }}" rel="stylesheet">
        <link href="{{ url('css/trending_tag.css') }}" rel="stylesheet">
        <link href="{{ url('css/article_page.css') }}" rel="stylesheet">
        <link href="{{ url('css/contacts.css') }}" rel="stylesheet">
        <link href="{{ url('css/profile.css') }}" rel="stylesheet">
        <link href="{{ url('css/filter.css') }}" rel="stylesheet">
        <link href="{{ url('css/popup.css') }}" rel="stylesheet">
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        <link href="{{ url('css/modal.css') }}" rel="stylesheet">
        <link href="{{ url('css/user_search.css') }}" rel="stylesheet">
        <link href="{{ url('css/notification_card.css') }}" rel="stylesheet">
        <!-- Scripts -->
        <script src="{{ url('js/dropdown.js') }}" defer> </script>
        <script src="{{ url('js/dropdown_tag_filter.js') }}" defer> </script>
        <script src="{{ url('js/dropdown_topic_filter.js') }}" defer> </script>
        <script src="{{ url('js/admin_panel.js') }}" defer></script>
        <script src="{{ url('js/user_feed.js') }}" defer></script>
        <script src="{{ url('js/popup.js') }}" defer> </script>
        <script src="{{ url('js/unfollow_profile_user.js') }}" defer> </script>
        <script src="{{ url('js/tag_create_article.js') }}" defer></script>
        <script src="{{ url('js/tag_edit_article.js') }}" defer></script>
        <script src="{{ url('js/article_interact.js') }}" defer> </script>
        <script src="{{ url('js/notifications_interect.js') }}" defer> </script>
        <script src="{{ url('js/comment_search_interact.js') }}" defer> </script>
        <script src="{{ url('js/follow_user.js') }}" defer> </script>
        <script src="{{ url('js/porpose_tag.js') }}" defer> </script>
    </head>
    <body>
        <a href="#main-content" class="skip-link">Skip to main content</a>
        <div class="wrapper">
            @include('layouts.header')
            <main id="main-content" class="content">
                @yield('content')
            </main>
            @include('layouts.footer')
        </div>
    </body>
</html>