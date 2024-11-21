@extends('layouts.homepage')

@section('content')
    <h1>Search Results</h1>
    <p>You searched for: {{ $searchQuery }}</p>
    <p>You searched for these tags:
        @foreach($tags as $tag)
            <a href="{{ route('search.show', ['tags' => [$tag->name]]) }}">{{ $tag->name }}</a>
        @endforeach
    </p>
    <p>You searched for these topics:
        @foreach($topics as $topic)
            <a href="{{ route('search.show', ['topics' => [$topic->name]]) }}">{{ $topic->name }}</a>
        @endforeach
    </p>
    @if($articleItems->isEmpty())
        <p>No articles found.</p>
    @else
        <div class="news-grid">
            @foreach($articleItems as $article)
                @include('partials.news_tile', ['article' => $article])
            @endforeach
        </div>
    @endif
@endsection