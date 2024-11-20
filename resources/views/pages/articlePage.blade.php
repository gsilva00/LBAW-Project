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
        <h1>{{ $article->title }}</h1>
        <p><strong>Created Date: </strong> {{ $article->create_date }}</p>
        <p><strong>Edited Date: </strong>
            @if($article->is_edited)
                {{ $article->edit_date }}
            @else
                No edition yet
            @endif
        </p>
        <p><strong>Subtitle: </strong> {{ $article->subtitle }}</p>
        <p><strong>Content: </strong>{{ $article->content }}</p>
        <p><strong>Author:</strong> {{ $authorDisplayName }}</p>
        <p><strong>Topic:</strong> {{ $topic->name }}</p>
        <p><strong>Tags:</strong>
            @foreach($tags as $tag)
                <span><strong>{{ $tag->name }}</strong></span>@if(!$loop->last)@endif
            @endforeach
        </div>
        </p>
        <p><strong>Upvotes: </strong> {{ $article->upvotes}}</p>
        <p><strong>Downvotes: </strong> {{ $article->downvotes}}</p>
        <div class="image-box">
            <img src="https://picsum.photos/seed/picsum/200/300" alt="News Image" width="200" height="300">
        </div>
        <div class="comments-section">
            <h2>Comments</h2>
            @foreach($comments as $comment)
                @include('partials.comment', ['comment' => $comment])
            @endforeach
        </div>
    </div>
    </section>
    <section class="more-news-section">
        <p>More News</p>
    </section>
</div>
@endsection