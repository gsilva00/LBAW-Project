@extends('layouts.app')

@section('title', 'Search')

@section('content')
    <div class="recent-news-wrapper">
        <h1 class="large-rectangle">Search Results</h1>
        <div class="large-rectangle">
            <p class="small-text">You searched for: {{ $searchQuery }}</p>
            <p class="small-text">You searched for these topics:
                @foreach($searchedTopics as $topic)
                    <span><strong><a href="{{ route('showTopic', ['name' => $topic->name]) }}">{{ $topic->name }}</a></strong></span>
                @endforeach
            </p>
            <p class="small-text">You searched for these tags:
                @foreach($searchedTags as $tag)
                    <span><strong><a href="{{ route('showTag', ['name' => $tag->name]) }}">{{ $tag->name }}</a></strong></span>@if(!$loop->last)@endif
                @endforeach
            </p>
        </div>

        @if($articleItems->isEmpty())
            <p>No articles found.</p>
        @else
            <div class="news-grid">
                @foreach($articleItems as $article)
                    @include('partials.news_tile', ['article' => $article])
                @endforeach
            </div>
        @endif
    </div>
@endsection