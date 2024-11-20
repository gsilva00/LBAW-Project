@extends('layouts.homepage')

@section('content')
    <div class="article-more-news-wrapper">
    <section class="article-section">
    <div class="large-rectangle">
        <a href="{{ $previousUrl }}">{{ $previousPage }}</a> >
        <span>{{ $topic->name }}</span> >
        <span>{{ $article->title }}</span>
    </div>
    <div class="news-article">
        <h1 class="article-title border-bottom" >{{ $article->title }}</h1>
        <div class="article-credits">
            <p class="small-text">By {{ $authorDisplayName }}</p>
            <p class="small-text">OCTOBER 27th of 2025</p>
            <button class="small-text">Report News</button>
        </div>
        <p class="article-subtitle">A marca iconica da balacha oreo esta de volta so que com mais cacau</p>
        <p class="small-text">By Getty Images</p>
        <p class="article-text border-bottom">{{ $article->content }}</p>
        <div class="large-rectangle tags">
            <span>Topic:</span>
            <span><strong> {{ $topic->name }}</strong></span>
            <span>Tags:</span>
            @foreach($tags as $tag)
                <span><strong>{{ $tag->name }}</strong></span>@if(!$loop->last)@endif
            @endforeach
        </div>
    </div>
    </section>
    <section class="more-news-section">
        <p>More News</p>
    </section>
</div>
@endsection