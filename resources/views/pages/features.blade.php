@extends('layouts.app')

@section('title', 'Features')

@section('content')
    <div id="footer-page-header">
        <div>
            <h1>NewFlow Features</h1>
            <p>Discover the untold stories and in-depth features that are shaping the world around us</p>
        </div>
    </div>
    <div id="footer-page-content">
        <div id="footer-page-phone">
            <div>
            <i class='bx bx-camera' ></i>
            <h2>Capture news</h2>
            <p>Capture your news into a permanent capsule, full of stories like yours.  
                Whether it's breaking news, in-depth investigations, or personal experiences, 
                NewFlow provides you the tools and the audience to make your voice heard. All you have to do is log in into the platform and start writting a new article!</p>
            </p>
            </div>
            <br>
            <button type="button" class="large-rectangle" onclick="
                    @if(Auth::check())
                        window.location='{{ route('createArticle') }}'
                    @else
                        window.location='{{ route('login') }}'
                    @endif
                    ">
                    <span>Start Writting</span>
            </button>
        </div>
        <div id="footer-page-mail">
            <div>
            <i class='bx bx-book-reader'></i>
            <h2>Dwelve into the unknown</h2>
            <p>Read all kinds of news from health to politics, technology to sports. Our platform offers a diverse range of articles to keep you informed and engaged. Dive deep into well-researched pieces and stay updated with the latest trends and developments.</p>
            </div>
            <br>
            <button type="button" class="large-rectangle" onclick="window.location='{{ route('showRecentNews') }}'">
                <span>Check The Latest</span>
            </button>
        </div>
        <div id="footer-page-pin">
            <div>
            <i class='bx bx-globe' ></i>
            <h2>Explore worldwide</h2>
            <p>Totally free, NewFlow is available worldwide for anyone with the thirst for unveilling the truth. Writer or reader, the pen is yours to embed and experience the history of the world.</p>
            </div>
            <br>
            <button type="button" class="large-rectangle" onclick="window.location='{{ route('homepage') }}'">
                    <span>Go Explore</span>
            </button>
        </div>
        <div id="footer-page-">
            <div>
            <i class='bx bx-conversation'></i>
            <h2>Talk with the community</h2>
            <p>Engage in discussions, share your thoughts, and connect with people with the same mind as you. Just share your comments below any news article you wish to express your opinion. Or simply reply to any fellow comments.</p>
            </div>
            <br>
            <button type="button" class="large-rectangle" onclick="window.location='{{ route('homepage') }}'">
                    <span>Give It A Try</span>
            </button>
        </div>
        <div id="footer-page-">
            <div>
            <i class='bx bx-donate-heart'></i>
            <h2>Vote based on your thoughts and emotions</h2>
            <p>Rise the best articles to the top by upvoting below the article content. However, if you disagree with them, you can always balance the scale by downvoting them. Of course, the same is possible for comments and replies.</p>
            </div>
            <br>
            <button type="button" class="large-rectangle" onclick="window.location='{{ route('showMostVotedNews') }}'">
                    <span>Visit The Leaderboards</span>
            </button>
        </div>
        <div id="footer-page-">
            <div>
            <i class='bx bx-block' ></i>
            <h2>Report bad behaviour</h2>
            <p>If any article depicts fake news, or a comment is showing anti-social behaviour like 'threatning someone', you can report the article, the comment or the user. If the case seems to be verified, our team will reduce the user's reputation, until they are permanently banned from the platform. Besides that, their articles will be invisible to the public.</p>
            </div>
            <br>
            <button type="button" class="large-rectangle" onclick="
                    @if(Auth::check())
                        window.location='{{ route('profile', ['username' => $user->username]) }}'
                    @else
                        window.location='{{ route('login') }}'
                    @endif
                    ">
                    <span>Check My Reputation</span>
            </button>
        </div>
        <div id="footer-page-">
            <div>
            <i class='bx bx-happy-heart-eyes'></i>
            <h2>Follow tags, topics and authors</h2>
            <p>Always trying to search news related to some topic? Now, it is easier than ever to store the topics, tags, and authors you wish to continue to read articles from. The User feed garantees all those articles in a compact and simple view.</p>
            </div>
            <br>
            <button type="button" class="large-rectangle" onclick="
                    @if(Auth::check())
                        window.location='{{ route('userFeed') }}'
                    @else
                        window.location='{{ route('login') }}'
                    @endif
                    ">
                    <span>View User Feed</span>
            </button>
        </div>
        <div id="footer-page-">
            <div>
            <i class='bx bx-extension'></i>
            <h2>Propose New Tags</h2>
            <p>Heard a new trand or scandalous news, which doesn't fit anywhere yet? You can propose a new tag that describes completely the artcile you are writting. When you create or edit an article, the option to propose a new tag will be available. If it is verified by our team, then the tag will be made public for everyone to use it.</p>
            </div>
            <br>
            <button type="button" class="large-rectangle" onclick="
                    @if(Auth::check())
                        window.location='{{ route('profile', ['username' => $user->username]) }}'
                    @else
                        window.location='{{ route('login') }}'
                    @endif
                    ">
                    <span>Try It On My Articles</span>
            </button>
        </div>
        <div id="footer-page-">
            <div>
            <i class='bx bx-star'></i>
            <h2>Save Memorable News</h2>
            <p>To never forget an article that fascinated you the most, you can click on 'Favorite Article' below the content of the article. Afterwards, you will have a direct link to the article among other liked articles inside the 'Favorite Articles' page. Removing the link is always possible by clicking again in the button.</p>
            </div>
            <br>
            <button type="button" class="large-rectangle" onclick="
                    @if(Auth::check())
                        window.location='{{ route('showFavouriteArticles') }}'
                    @else
                        window.location='{{ route('login') }}'
                    @endif
                    ">
                    <span>See My Favorite Articles</span>
            </button>
        </div>
        <div id="footer-page-">
            <div>
            <i class='bx bx-bell' ></i>
            <h2>Be Updated</h2>
            <p>Don't miss any interaction happening on your news article by turning on the notifications settings. From upvotes to comments, you will be able to observe every action on the 'Notifications' pannel. You can always archived the notifications after reading them or go directly to the buzz.</p>
            </div>
            <br>
            <button type="button" class="large-rectangle" onclick="
                    @if(Auth::check())
                        window.location='{{ route('showNotificationsPage') }}'
                    @else
                        window.location='{{ route('login') }}'
                    @endif
                    ">
                    <span>Explore Notifications</span>
            </button>
        </div>
    </div>

@endsection