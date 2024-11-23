<header>
    <div id="top-part-header">
        <h1><a href="{{ route('homepage') }}" class="logo"> {{ config('app.name', 'Laravel') }}</a></h1>
        <h2><i class='bx bx-heart'></i> Followed Authors' News</h2>
        <h2><i class='bx bx-purchase-tag'></i> Followed Tags</h2>
        <h2><i class='bx bx-book'></i> Followed Topics</h2>
        <div id="profile" class="dropdown">
            @if(Auth::check())
                <button type="button" id="profile-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class='bx bx-user-circle'></i>
                    <h2>{{$username}}</h2>
                </button>
                <div class="dropdown-menu" aria-labelledby="profile-button">
                    <a class="dropdown-item" href="{{ route('profile', ['username' => $username]) }}"><h2>See Profile</h2></a>
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><h2>Logout</h2></a>
                    <a class="dropdown-item" href="#"><h2>Something for admin</h2></a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">
                    @csrf
                </form>
            @else
                <a id="profile-button" href="{{ route('login') }}">
                    <i class='bx bx-user-circle'></i><h2>Login</h2>
                </a>
            @endif
        </div>  <!-- Needs to be change to get login/logout -->
    </div>
    <div id="bottom-part-header">
        <a href="{{ route('homepage') }}"><h2><i class='bx bx-home-alt'></i> Homepage</h2></a>
        <a href="{{ route('recentnews.show') }}"><h2><i class='bx bx-stopwatch'></i>Most Recent News</h2></a>
        <a href="{{ route('votednews.show') }}"><h2><i class='bx bx-sort'></i> Most Voted News</h2></a>
        <h2><i class='bx bx-trending-up'></i>Trending Tags</h2>
        <h2 class="topic">
            <a href="{{ route('search.show', ['topics' => ['Politics']]) }}">Politics</a>
        </h2>
        <h2 class="topic">
            <a href="{{ route('search.show', ['topics' => ['Business']]) }}">Business</a>
        </h2>
        <h2 class="topic">
            <a href="{{ route('search.show', ['topics' => ['Technology']]) }}">Technology</a>
        </h2>
        <h2 class="topic">
            <a href="{{ route('search.show', ['topics' => ['Science']]) }}">Science</a>
        </h2>
        <h2><i class='bx bx-news'></i>All Topics</h2>
        @include('partials.search',['tags' => $tags, 'topics' => $topics])
    </div>
</header>