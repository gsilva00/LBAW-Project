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
            <h2><i class='bx bx-home-alt'></i> Homepage</h2>
            <h2><i class='bx bx-stopwatch'></i>Most Recent News</h2>
            <h2><i class='bx bx-sort'></i> Most Voted News</h2>
            <h2><i class='bx bx-trending-up'></i>Trending Tags</h2>
            <h2 class="topic">Politcs</h2>   <!-- Needs to be change to get 5 topics from database -->
            <h2 class="topic">Business</h2>
            <h2 class="topic">Technology</h2>
            <h2 class="topic">Science</h2>
            <h2><i class='bx bx-news'></i>All Topics</h2>
            <button type="button" id="search-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-search'></i>
            </button>
            <div class="dropdown-menu" id="search-menu" aria-labelledby="search-button">
                <form class="dropdown-item" action="{{ route('search.show') }}" method="GET">
                    @include('partials.search_form')
                </form>
            </div>
        </div>
</header>