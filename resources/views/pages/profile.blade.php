@extends('layouts.app')

@section('title')
    @if($isOwner)
        Your Profile
    @else
        {{ $profileUser->display_name }}'s Profile
    @endif
@endsection

@section('content')
    <div class="profile-wrapper">
        <section class="profile-container">
            <img src="{{ asset('images/profile/' . $profileUser->profile_picture) }}" alt="profile_picture">
            <div class="profile-info">
                <h1>{{ $profileUser->display_name }}'s Profile</h1>
                @if($isOwner || $isAdmin)
                    <a href="{{ route('editProfile', ['username' => $profileUser->username])}}">
                        <button class="large-rectangle small-text greyer">Edit Profile</button>
                    </a>
                @endif
                @if(Auth::check() && !$isOwner)
                <form id="follow-user-form" method="POST">
                    @csrf
                    <button type="button" id="follow-user-button" class="large-rectangle small-text greyer">
                        {{ Auth::user()->isFollowing($user) ? 'Unfollow User' : 'Follow User' }}
                    </button>
                </form>
                @endif
            </div>
            <div id="rest-profile-info">
                @if($isOwner)
                    <span class="small-text"> Your username:</span>
                    <span><strong> {{ $profileUser->username }} </strong></span>
                @endif

                <p class="small-text">Description:</p>
                <span>{{ $profileUser->description }}</span>
            </div>
            </section>
            @if($isOwner || $isAdmin)
            <section>
                <h2 id="favoriteTopicTitle">Favorite Topics</h2>
                @if($profileUser->followedTopics->isEmpty())
                    <div class="not-available-container">
                        <p>No favorite topics.</p>
                    </div>
                @else
                        <div class="selected">
                    @foreach($profileUser->followedTopics as $topic)
                        <div class="block">
                            <span>{{ $topic->name }}</span><button class="remove" data-url="{{ route('unfollowTopic', $topic->name) }}" data-topic-id="{{ $topic->id }}">&times;</button>
                        </div>
                    @endforeach
                        </div>
                @endif
            </section>
            <section>
                <h2 id="favoriteTagTitle">Favorite Tags</h2>
                @if($profileUser->followedTags->isEmpty())
                    <div class="not-available-container">
                        <p>No favorite tags.</p>
                    </div>
                @else
                    <div class="selected">
                        @foreach($profileUser->followedTags as $tag)
                            <div class="block">
                                <span>{{ $tag->name }}</span><button class="remove" data-url="{{ route('unfollowTag', $tag->name) }}" data-tag-id="{{ $tag->id }}">&times;</button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <section>
                <h2>Favorite Authors</h2>
                @if($profileUser->following->isEmpty())
                <div class="not-available-container">
                        <p>No favorite authors.</p>
                    </div>
                @else
                <div id="users-section">
                <div id="user-list">
                        @foreach($profileUser->following as $fav_author)
                            @include('partials.user_tile', ['user' => $fav_author])
                        @endforeach
                </div>
                </div>
                @endif
            </section>
        @endif
        <div class="profile-info">
            @if($isOwner)
                <h2> Your articles</h2>
            @else
                <h2> Articles by {{ $profileUser->display_name }}</h2>
            @endif

            @if($isOwner)
                <a href="{{ route('createArticle')}}">
                    <button class="large-rectangle small-text">Create New Article</button>
                </a>
            @endif

        </div>

        @if($ownedArticles->isNotEmpty())
            <div class="sec-articles profile-page">
                @foreach($ownedArticles as $article)
                    @include('partials.news_tile', [
                        'article' => $article,
                    ])
                @endforeach
            </div>
        @else
            <div class="not-available-container">
                <p>No articles available.</p>
            </div>
        @endif
    </div>

@endsection