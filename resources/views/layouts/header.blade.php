<header>
    <div id="top-part-header">
        <h1><a href="{{ route('homepage') }}" class="logo"> {{ config('app.name', 'Laravel') }}</a></h1>
        <a href="{{ route('userFeed') }}">
            <h2><i class='bx bx-book'></i> User Feed</h2>
        </a>
        <div id="profile" class="dropdown">
            @if(Auth::check())
                <button type="button" id="profile-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class='bx bx-user-circle'></i>
                    <h2>{{$user->username}}</h2>
                </button>
                <div class="dropdown-menu" aria-labelledby="profile-button">
                    <a class="dropdown-item" href="{{ route('profile', ['username' => $user->username]) }}"><h2>See Profile</h2></a>
                    <a class="dropdown-item" href="{{ route('showFavouriteArticles') }}"><h2>Favourite Articles</h2></a>
                    @if($user->is_admin)
                        <a class="dropdown-item" href="{{ route('adminPanel') }}"><h2>Administrator Panel</h2></a>
                    @endif
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><h2>Logout</h2></a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a id="profile-button" href="{{ route('login') }}">
                    <i class='bx bx-user-circle'></i><h2>Login</h2>
                </a>
            @endif
        </div>
    </div>
    <div id="bottom-part-header">
        <a href="{{ route('homepage') }}"><h2><i class='bx bx-home-alt'></i> Homepage</h2></a>
        <a href="{{ route('showRecentNews') }}"><h2><i class='bx bx-stopwatch'></i>Most Recent News</h2></a>
        <a href="{{ route('showMostVotedNews') }}"><h2><i class='bx bx-sort'></i> Most Voted News</h2></a>
        <a href="{{ route('showTrendingTags') }}"><h2><i class='bx bx-trending-up'></i>Trending Tags</h2></a>
        <h2 class="topic">
            <a href="{{ route('showTopic', ['name' => 'Politics']) }}">Politics</a>
        </h2>
        <h2 class="topic">
            <a href="{{ route('showTopic', ['name' => 'Business']) }}">Business</a>
        </h2>
        <h2 class="topic">
            <a href="{{ route('showTopic', ['name' => 'Technology']) }}">Technology</a>
        </h2>
        <h2 class="topic">
            <a href="{{ route('showTopic', ['name' => 'Science']) }}">Science</a>
        </h2>
        <button class="h2" type="button" id="all-topics-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class='bx bx-news'></i>
            <span>All Topics</span>
        </button>
        <div class="dropdown-menu" aria-labelledby="all-topics-button">
            @foreach($topics as $topic)
                <a class="dropdown-item" href="{{ route('showTopic', ['name' => $topic->name]) }}"><h2>{{ $topic->name }}</h2></a>
            @endforeach
        </div>
        @include('partials.search',['tags' => $tags, 'topics' => $topics])
    </div>
</header>