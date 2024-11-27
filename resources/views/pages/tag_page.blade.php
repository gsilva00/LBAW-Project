@extends('layouts.app')

@section('title')
    #{{ $tag->name }}
@endsection

@section('content')
    <div class="recent-news-wrapper">
        <div class="profile-info">
        <h1 class="large-rectangle">#{{ $tag->name }}</h1>
        @if(Auth::check())
        <form method="POST" action="{{ Auth::user()->hasFollowedTag($tag) ? route('tag.unfollow', $tag) : route('tag.follow', $tag) }}">
            @csrf
            <button type="submit" class="large-rectangle small-text greyer">
                {{ Auth::user()->hasFollowedTag($tag) ? 'Unfollow Tag' : 'Follow Tag' }}
            </button>
        </form>
        @endif
        </div>
        <div class="recent-news-container">
            @foreach($tag->articles as $article)
                @include('partials.long_news_tile', [
                    'article' => $article,
                ])
            @endforeach
        </div>
    </div>

@endsection