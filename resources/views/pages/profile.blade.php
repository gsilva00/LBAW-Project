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