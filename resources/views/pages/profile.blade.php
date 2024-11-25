@extends('layouts.homepage')

@section('content')
    <div class="profile-wrapper">
        <section class="profile-container">
            <img src="{{ asset('images/profile/' . $userprofile->profile_picture) }}" alt="profile_picture">
            <div class="profile-info">
                <h1>{{ $userprofile->display_name }}'s Profile</h1>
                @if($isOwner || $isAdmin)
                    <a href="{{ route('profile.edit')}}"><button class="large-rectangle small-text greyer">Edit Profile</button></a>  <!--Need to do action here IF ITS ADMIN EDITING NOT ITS OWN ACCOUNT -->
                @endif
                <!--@if($user->isAdmin)
                    <button class="large-rectangle small-text greyer">
                    @if($user->isBanned)
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
                    <span><strong> {{ $userprofile->username }} </strong></span>
                @endif

                <p class="small-text">Description:</p>
                <span>{{ $userprofile->description }}</span>
            </div>
        </section>

        <div class="profile-info">
            @if($isOwner)
                <h2> Your articles</h2>
            @else
                <h2> Articles by {{ $userprofile->display_name }}</h2>
            @endif

            @if($isOwner)
                <a href="{{ route('createArticle')}}"><button class="large-rectangle small-text">Create New Article</button></a>  <!--Need to do action here -->
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