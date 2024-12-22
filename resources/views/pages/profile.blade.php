@extends('layouts.app')

@section('title')
    @if($isOwner)
        My Profile
    @else
        {{ $profileUser->display_name }}'s Profile
    @endif
@endsection

@section('content')
    <div class="profile-wrapper" data-user-id="{{$profileUser->id}}">
        <section class="profile-container">
            <img src="{{ asset('images/profile/' . $profileUser->profile_picture) }}" alt="Your profile picture">
            <div class="profile-info">
                <h1>{{ $profileUser->display_name }}'s Profile</h1>
                @if($isOwner || $isAdmin)
                    <a href="{{ route('editProfile', ['username' => $profileUser->username]) }}" class="large-rectangle small-text greener">
                        Edit Profile
                    </a>
                @endif
                @if($isOwner && $user->is_banned)
                    <button type="button" id="unban-appeal-button" class="large-rectangle small-text greener" data-action-url="{{ route('appealUnbanShow') }}">
                        Appeal Unban
                    </button>
                @endif
                @if(Auth::check() && !$isOwner)
                    <button type="button" id="follow-user-button" class="large-rectangle small-text greener"
                            data-user-id="{{ $user->id }}" data-profile-id="{{ $profileUser->id }}" data-url="{{Auth::user()->isFollowingUser($profileUser->id) ? route('unfollowUserAction') : route('followUserAction')}}">
                        {{ Auth::user()->isFollowingUser($profileUser->id) ? 'Unfollow User' : 'Follow User' }}
                    </button>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                @endif
                @if(Auth::check() && !$isOwner && !$isAdmin)
                    <button type="button" id="report-user-button" class="large-rectangle small-text greener">
                            Report User
                    </button>
                @endif
                @if(!$isOwner && $isAdmin)
                    <form action="{{ route('deleteProfile', ['id' => $profileUser->id]) }}" method="POST" data-action="delete" style="display:inline;">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $profileUser->id }}">
                        <button type="submit" class="large-rectangle small-text greyer">Delete This Account</button>
                    </form>
                @endif
            </div>
            <div id="rest-profile-info">
                @if($isOwner)
                    <span class="small-text"> Your username:</span>
                    <span><strong> {{ $profileUser->username }} </strong></span>
                @endif
                <div class="profile-info">
                <p class="small-text">Reputation:</p>
                @if( $profileUser->reputation == 0)
                    <i class='bx bx-dice-1'></i>
                @elseif($profileUser->reputation == 1)
                    <i class='bx bx-dice-2'></i>
                @elseif($profileUser->reputation == 2)
                    <i class='bx bx-dice-3'></i>
                @elseif($profileUser->reputation == 3)
                    <i class='bx bx-dice-4'></i>
                @elseif($profileUser->reputation == 4)
                    <i class='bx bx-dice-5'></i>
                @else
                    <i class='bx bx-dice-6'></i>
                @endif
                </div>
                <p class="small-text">Description:</p>
                <span>{{ $profileUser->description }}</span>
            </div>
        </section>
        @if($isOwner || $isAdmin)
            <section>
                <h2 id="favouriteTopicTitle">Favourite Topics</h2>
                @if($profileUser->followedTopics->isEmpty())
                    <div class="not-available-container">
                        <p>No favourite topics.</p>
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
                <h2 id="favouriteTagTitle">Favourite Tags</h2>
                @if($profileUser->getFollowedTags()->isEmpty())
                    <div class="not-available-container">
                        <p>No favourite tags.</p>
                    </div>
                @else
                    <div class="selected">
                        @foreach($profileUser->getFollowedTags() as $tag)
                            <div class="block">
                                <span>{{ $tag->name }}</span><button class="remove" data-url="{{ route('unfollowTag', $tag->name) }}" data-tag-id="{{ $tag->id }}">&times;</button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
            <section>
                <h2>Favourite Authors</h2>
                @if($profileUser->following->isEmpty())
                <div class="not-available-container">
                        <p>No favourite authors.</p>
                    </div>
                @else
                <div id="users-section">
                    <div id="user-list">
                            @foreach($profileUser->following as $fav_author)
                                @include('partials.user_tile', ['user' => $fav_author, 'isAdminPanel' => false])
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
                <button type="button" onclick="window.location='{{ route('createArticle') }}'" class="large-rectangle small-text">
                    Create New Article
                </button>
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