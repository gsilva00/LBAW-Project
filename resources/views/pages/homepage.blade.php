@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="homepage-wrapper">
        @if($articleItems->isNotEmpty())
            <div class="first-article">
                @include('partials.first_tile', ['article' => $articleItems->first()])
            </div>
            <div class="sec-articles">
                @foreach($articleItems->slice(1) as $article)
                    @include('partials.news_tile', [
                        'article' => $article,
                    ])
                @endforeach
            </div>
        @else
            <p>No articles available.</p>
        @endif
        <nav class="news-tab-section">
            @include('partials.trending_tags',['trendingTags' => $trendingTags])
            @include('partials.recent_news',['recentNews' => $recentNews])
        </nav>
    </div>
@endsection
