@extends('layouts.homepage')

@section('content')
<div class="article-more-news-wrapper">
    <section class="article-section">
        <div class="large-rectangle breadcrumbs">
            <a href="{{ $previousUrl }}" class="thin">{{ $previousPage }}</a> >
            <span class="thin">{{ $topic->name }}</span> >
            <span class="thin">{{ $article->title }}</span>
        </div>
        <div class="news-article">
            <h1 class="article-title border-bottom" >{{ $article->title }}</h1>
            <div class="article-credits">
                <p class="small-text">By {{ $authorDisplayName }}</p>
                <p class="small-text">Created at: {{ $article->create_date }}</p>
                <p class="small-text">
                @if($article->is_edited)
                    Edited at: {{ $article->edit_date }}
                @else
                @endif
                </p>
                <button id="report-button" class="large-rectangle small-text"><span>Report News</span></button>  <!-- Needs to be implemented -->
            </div>
            <p class="title">{{ $article->subtitle }}</p>
            <div>
                <img class="article-image" src="https://picsum.photos/seed/picsum/1200/1300" alt="News Image">
            </div>
            <p class="article-text border-bottom">{{ $article->content }}</p>
            <div class="large-rectangle tags">
                <span class="thin">Topic:</span>
                <span><strong><a href="{{ route('search.show', ['topics' => [$topic->name]]) }}">{{ $topic->name }}</a></strong></span>
                <span class="thin">Tags:</span>
                @foreach($tags as $tag)
                    <span><strong><a href="{{ route('search.show', ['tags' => [$tag->name]]) }}">{{ $tag->name }}</a></strong></span>@if(!$loop->last)@endif
                @endforeach
            </div>

            <div class="large-rectangle article-votes"><button><i class='bx bx-upvote'></i></button><p><strong>{{ $article->upvotes - $article->downvotes}}</strong></p><button><i class='bx bx-downvote' ></i></button></div>


            <div class="comments-section">
                <h2>Comments</h2>
                @foreach($comments as $comment)
                    @include('partials.comment', ['comment' => $comment])
                @endforeach
            </div>
        </div>
    </section>
    <section class="news-tab-section">
        @include('partials.trending_tags',['trendingTags' => $trendingTags])
        @include('partials.recent_news',['recentNews' => $recentNews])
    </section>
</div>
@endsection