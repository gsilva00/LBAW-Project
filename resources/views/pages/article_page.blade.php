@extends('layouts.app')

@section('title', $article->is_deleted ? '[Deleted]' : $article->title)

@section('content')
    <div class="article-more-news-wrapper">
        <section class="article-section">
            <div class="large-rectangle breadcrumbs">
                <a href="{{ $previousUrl }}" class="thin">{{ $previousPage }}</a> >
                <a class="thin" href="{{ route('showTopic', ['name' => $topic->name]) }}">{{ $topic->name }}</a> >
                <span class="thin">{{ $article->is_deleted ? '[Deleted]' : $article->title }}</span>
            </div>
            <div class="news-article">
                <h1 class="article-title border-bottom">{{ $article->is_deleted ? '[Deleted]' : $article->title }}</h1>
                <div class="article-credits">
                    <p class="small-text">
                        By
                        @if($article->is_deleted)
                            Anonymous
                        @else
                            <a href="{{ route('profile', ['username' => $article->author->username]) }}">{{ $authorDisplayName }}</a>
                        @endif
                    </p>
                    <p class="small-text">
                        @if($article->is_edited)
                            Edited at: {{ $article->edit_date }}
                        @else
                            Created at: {{ $article->create_date }}
                        @endif
                    </p>
                    <button class="small-text small-rectangle" title="report news"><span>Report News</span></button>  <!-- Needs to be implemented -->
                </div>
                <p class="title">{{ $article->is_deleted ? '[Deleted]' : $article->subtitle }}</p>
                <div>
                    <img class="article-image" src="{{ $article->is_deleted ? asset('images/article/default.jpg') : asset('images/article/' . $article->article_image) }}" alt="News Image">
                </div>
                @if($article->is_deleted)
                    <p class="thin">[Deleted]</p>
                @else
                    @foreach($paragraphs as $paragraph)
                        <p class="thin">{{ $paragraph }}</p>
                    @endforeach
                @endif
                <div class="large-rectangle tags">
                    <span class="thin">Topic:</span>
                    <span><strong><a href="{{ route('showTopic', ['name' => $topic->name]) }}">{{ $topic->name }}</a></strong></span>
                    <span class="thin">Tags:</span>
                    @foreach($articleTags as $tag)
                        <span><strong><a href="{{ route('showTag', ['name' => $tag->name]) }}">{{ $tag->name }}</a></strong></span>@if(!$loop->last)@endif
                    @endforeach
                </div>
                <div class="article-actions">      
                        @if(Auth::check() && $user->favouriteArticles->contains($article->id))
                        <button class="small-rectangle fit-block favorite" title="Save Article"><i class='bx bxs-star'></i><span>Saved
                        @else
                        <button class="small-rectangle fit-block favorite" title="Save Article"><i class='bx bx-star'></i><span> Save Article
                        @endif
                    </span></button>
                    <div class="small-rectangle fit-block"><button title="upvote article"><i class='bx bx-upvote'></i></button><span><strong>{{ $article->upvotes - $article->downvotes}}</strong></span><button title="downvote article"><i class='bx bx-downvote' ></i></button></div>
                </div>

                <div class="comments-section">
                    <h2>Comments</h2>
                    <form class="comment">
                        @if(Auth::guest() || $user->is_deleted)
                            <img src="{{ asset('images/profile/default.jpg') }}" alt="profile_picture">
                        @else
                            <img src="{{ asset('images/profile/' . $user->profile_picture) }}" alt="profile_picture">
                        @endif
                        <div class="comment-input-container">
                            <input type="text" class="comment-input" placeholder="Write a comment..." @if(Auth::guest() || $user->is_deleted) disabled @endif>

                            <button class="small-rectangle" title="Send comment" @if(Auth::guest() || $user->is_deleted) disabled @endif><i class='bx bx-send remove-position'></i><span>Send</span></button>
                        </div>
                    </form>
                    <br>
                    <br>
                    @if($comments->isEmpty())
                        <div class="not-available-container">
                            <p>No comments available.</p>
                        </div>
                    @else
                        @foreach($comments as $comment)
                            @include('partials.comment', ['comment' => $comment, 'replies' => $comment->replies, 'user' => $user])
                            @if($comment->replies->isNotEmpty())
                                <button class="small-rectangle see-replies-button" title="See replies"><i class='bx bx-chevron-down remove-position' ></i><span>{{ $comment->replies->count() }} {{ $comment->replies->count() > 1 ? 'Answers' : 'Answer' }}</span></button>
                                <div class="reply">
                                @foreach($comment->replies as $reply)
                                    @include('partials.comment', ['comment' => $reply])
                                @endforeach
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
        <nav class="news-tab-section">
            @include('partials.trending_tags',['trendingTags' => $trendingTags])
            @include('partials.recent_news',['recentNews' => $recentNews])
        </nav>
    </div>
@endsection