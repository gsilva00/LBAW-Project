@extends('layouts.app')

@section('content')
<div class="recent-news-wrapper">
    <h1 class="large-rectangle">Saved Articles</h1>
    @if($savedArticles->isEmpty())
        <div class="not-available-container">
            <p>No saved articles available.</p>
        </div>
    @else
        <div class="articles-list">
            @foreach($savedArticles as $article)
                @include('partials.long_news_tile', [
                        'article' => $article,
                    ])
            @endforeach
        </div>
    @endif
</div>
@endsection