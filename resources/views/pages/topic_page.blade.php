@extends('layouts.app')

@section('title', $topic->name)

@section('content')
    <div class="recent-news-wrapper">
        <div class="profile-info">
        <h1 class="large-rectangle">{{ $topic->name }}</h1>
        @if(Auth::check())
        <form method="POST" action="{{ Auth::user()->hasFollowedTopic($topic) ? route('unfollowTopic', $topic->name) : route('followTopic', $topic->name) }}">
            @csrf
            <button type="submit" class="large-rectangle small-text greener">
                {{ Auth::user()->hasFollowedTopic($topic) ? 'Unfollow topic' : 'Follow topic' }}
            </button>
        </form>
        @endif
        </div>
        <div class="recent-news-container">
            @foreach($topic->articles as $article)
                @include('partials.long_news_tile', [
                    'article' => $article,
                ])
            @endforeach
        </div>
    </div>

@endsection
