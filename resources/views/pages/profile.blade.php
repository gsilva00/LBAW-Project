@extends('layouts.homepage')

@section('content')
    <div class="profile-wrapper">
        <section class="profile-container">
            <img src="{{ asset('images/profile/' . $profilePicture) }}" alt="profile_picture">
        <div class="profile-info">
        <h1>{{ $displayName }}'s Profile</h1>
        @if($isOwner || $isAdmin)
            <a href="{{ route('profile.edit')}}"><button class="large-rectangle small-text greyer">Edit Profile</button></a>  <!--Need to do action here IF ITS ADMIN EDITING NOT ITS OWN ACCOUNT -->
        @endif
        <!--@if($isAdmin)
            <button class="large-rectangle small-text greyer">
            @if($isBanned)
                Unban User
            @else
                Ban User
            @endif
            </button>

            <button class="large-rectangle small-text greyer"> Delete User </button>
        @endif -->
        </div>
        <div id="rest-profile-info">
        @if($isOwner)
        <span class="small-text"> Your username:</span>
        <span><strong> {{ $profileUsername }} </strong></span>
        @endif

        <p class="small-text">Description:</p>
        <span>{{ $description }}</span>
        </div>
</section>

    <div class="profile-info">
        @if($isOwner)
            <h2> Your articles</h2>
        @else
            <h2> Articles by {{ $displayName }}</h2>
        @endif

        @if($isOwner)
            <a href="{{ route('createArticle')}}"><button class="large-rectangle small-text greyer">Create New Article</button></a>  <!--Need to do action here -->
        @endif

    </div>


    @if($ownedArticles->isNotEmpty())
    <div class="sec-articles">
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