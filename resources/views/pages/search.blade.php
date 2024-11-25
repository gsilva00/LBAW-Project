@extends('layouts.homepage')

@section('content')
<div class="recent-news-wrapper">
    <h1 class="large-rectangle">Search Results</h1>
    <div class="large-rectangle">
    <p class="small-text">You searched for: {{ $searchQuery }}</p>
    <p class="small-text">You searched for these tags:
        @foreach($searchedTags as $tag)
            <a href="{{ route('search.show', ['tags' => [$tag->name]]) }}">{{ $tag->name }}</a>
        @endforeach
    </p>
    <p class="small-text">You searched for these topics:
        @foreach($searchedTopics as $topic)
            <a href="{{ route('search.show', ['topics' => [$topic->name]]) }}">{{ $topic->name }}</a>
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