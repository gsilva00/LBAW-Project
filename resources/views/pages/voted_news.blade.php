@extends('layouts.app')

@section('title', 'Most Voted News')

@section('content')
    <div class="recent-news-wrapper">
        <h1 class="large-rectangle">Most Voted News</h1>
        @if($votedNews->isNotEmpty())
            <div class="recent-news-container">
                @foreach($votedNews as $article)
                    @include('partials.long_news_tile', [
                        'article' => $article,
                    ])
                @endforeach
            </div>
        @else
            <p>No news articles available.</p>
        @endif
    </div>
@endsection