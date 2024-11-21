@extends('layouts.homepage')

@section('content')
    <div class="recent-news-wrapper">
        <h1 class="large-rectangle">Most Recent News</h1>
        @if($recentNews->isNotEmpty())
            <div class="recent-news-container">
            @foreach($recentNews as $article)
                @include('partials.long_news_tile', [
                    'article' => $article,
                ])
            @endforeach
            </div>
        @else
            <p>No recent news available.</p>
        @endif
    </div>
@endsection