@extends('layouts.app')

@section('title', 'Favourite Articles')

@section('content')
<div class="recent-news-wrapper">
    <h1 class="large-rectangle">Favourite Articles</h1>
    @if($favArticles->isEmpty())
        <div class="not-available-container">
            <p>You have no favourite articles yet.</p>
        </div>
    @else
        <div class="recent-news-container">
            @foreach($favArticles as $article)
                @include('partials.long_news_tile', [
                        'article' => $article,
                    ])
            @endforeach
        </div>
    @endif
</div>
@endsection