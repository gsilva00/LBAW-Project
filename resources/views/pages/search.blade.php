@extends('layouts.homepage')

@section('content')
    <h1>Search Results</h1>
    <p>You searched for: {{ $searchQuery }}</p>
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