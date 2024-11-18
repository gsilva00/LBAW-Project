<header>
        <div id="top-part-header">
            <h1 class="title">{{ config('app.name', 'Laravel') }}</h1>
            <h2><i class='bx bx-heart'></i> Followed Authors' News</h2>
            <h2><i class='bx bx-purchase-tag'></i> Followed Tags</h2>
            <h2><i class='bx bx-book'></i> Followed Topics</h2>
            <h2 class="profile">
                <i class='bx bx-user-circle'></i>
                <div class="dropdown">
                    @if(Auth::check())
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            JOAO <!-- Needs to be change to get username -->
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <a class="dropdown-item" href="#">Something for admin</a>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">
                        @csrf
                    </form>
                    @else
                    <a class="button" href="{{ route('login') }}">
            <           button type="button">Login</button>
                    </a>
                @endif
                </div>
            </h2>  <!-- Needs to be change to get login/logout -->
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
            <h2><i class='bx bx-search'></i></h2>
        </div>
</header>