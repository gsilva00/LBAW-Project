@extends('layouts.homepage')

@section('content')
<div class="recent-news-wrapper">
    <h1 class="large-rectangle">{{ $tag->name }}</h1>
    <div class="recent-news-container">
        @foreach($tag->articles as $article)
            @include('partials.long_news_tile', [
                'article' => $article,
            ])
        @endforeach
    </div>
</div>

@endsection