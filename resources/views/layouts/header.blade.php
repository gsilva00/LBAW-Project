<header>
    <div id="top-part-header">
        <h1><a href="{{ route('homepage') }}" class="logo"> {{ config('app.name', 'Laravel') }}</a></h1>
        <a href="{{ route('userFeed') }}" class="{{ Route::currentRouteName() == 'userFeed' ? 'active' : '' }}">
            <h2><i class='bx bx-book'></i> User Feed</h2>
        </a>
        <div id="profile" class="dropdown">
            @if(Auth::check())
                <button type="button" id="profile-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class='bx bx-user-circle'></i>
                    <span class="thick">{{$user->username}}</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="profile-button">
                    <a class="dropdown-item {{ Route::currentRouteName() == 'profile' ? 'active-secondary' : '' }}" href="{{ route('profile', ['username' => $user->username]) }}"><h2>See Profile</h2></a>
                    <a class="dropdown-item {{ Route::currentRouteName() == 'notifications.show.page' ? 'active-secondary' : '' }}" href="{{ route('notifications.show.page') }}"><h2>Notifications</h2></a>
                    <a class="dropdown-item {{ Route::currentRouteName() == 'showFavouriteArticles' ? 'active-secondary' : '' }}" href="{{ route('showFavouriteArticles') }}"><h2>Favourite Articles</h2></a>
                    @if($user->is_admin)
                        <a class="dropdown-item {{ Route::currentRouteName() == 'adminPanel' ? 'active-secondary' : '' }}" href="{{ route('adminPanel') }}"><h2>Administrator Panel</h2></a>
                    @endif
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><h2>Logout</h2></a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <button type="button" id="profile-button" onclick="window.location='{{ route('login') }}'">
                    <i class='bx bx-user-circle'></i>
                    <span class="thick">Login</span>
                </button>
            @endif
        </div>
    </div>
    <div id="bottom-part-header">
        <a class="{{ Route::currentRouteName() == 'homepage' ? 'active' : '' }}" href="{{ route('homepage') }}"><h2><i class='bx bx-home-alt'></i>Homepage</h2></a>
        <a class="{{ Route::currentRouteName() == 'showRecentNews' ? 'active' : '' }}" href="{{ route('showRecentNews') }}"><h2><i class='bx bx-stopwatch'></i>Most Recent News</h2></a>
        <a class="{{ Route::currentRouteName() == 'showMostVotedNews' ? 'active' : '' }}" href="{{ route('showMostVotedNews') }}"><h2><i class='bx bx-sort'></i>Most Voted News</h2></a>
        <a class="{{ Route::currentRouteName() == 'showTrendingTags' ? 'active' : '' }}" href="{{ route('showTrendingTags') }}"><h2><i class='bx bx-trending-up'></i>Trending Tags</h2></a>
        <h2 class="topic">
            <a href="{{ route('showTopic', ['name' => 'Politics']) }}" class="{{ Route::currentRouteName() == 'showTopic' && Route::input('name') == 'Politics' ? 'active' : '' }}">Politics</a>
        </h2>
        <h2 class="topic">
            <a href="{{ route('showTopic', ['name' => 'Business']) }}" class="{{ Route::currentRouteName() == 'showTopic' && Route::input('name') == 'Business' ? 'active' : '' }}">Business</a>
        </h2>
        <h2 class="topic">
            <a href="{{ route('showTopic', ['name' => 'Technology']) }}" class="{{ Route::currentRouteName() == 'showTopic' && Route::input('name') == 'Technology' ? 'active' : '' }}">Technology</a>
        </h2>
        <h2 class="topic">
            <a href="{{ route('showTopic', ['name' => 'Science']) }}" class="{{ Route::currentRouteName() == 'showTopic' && Route::input('name') == 'Science' ? 'active' : '' }}">Science</a>
        </h2>
        <button class="h2" type="button" id="all-topics-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class='bx bx-news'></i>
            <span>All Topics</span>
        </button>
        <div class="dropdown-menu" aria-labelledby="all-topics-button">
            @foreach($topics as $topic)
                <a class="dropdown-item {{ Route::currentRouteName() == 'showTopic' && Route::input('name') == $topic->name ? 'active-secondary' : '' }}" href="{{ route('showTopic', ['name' => $topic->name]) }}"><h2>{{ $topic->name }}</h2></a>
            @endforeach
        </div>
        @include('partials.search',['tags' => $tags, 'topics' => $topics])
    </div>
</header>