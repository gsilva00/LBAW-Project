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
                    <button class="small-rectangle fit-block favorite" title="Save Article" data-favorite-url="{{ route('article.favourite', ['id' => $article->id]) }}">
                        @if(Auth::check() && $favourite)
                            <i class='bx bxs-star'></i><span>Saved</span>
                        @else
                            <i class='bx bx-star'></i><span>Save Article</span>
                        @endif
                    </button>
                                    <div class="large-rectangle article-votes">
                    <button id="upvote-button" data-upvote-url="{{ route('article.upvote', ['id' => $article->id]) }}">
                    @if($voteArticle == 1)
                            <i class='bx bxs-upvote'></i>
                        @else
                            <i class='bx bx-upvote'></i>
                        @endif
                </button>
                <p><strong>{{ $article->upvotes - $article->downvotes }}</strong></p>
                <button id="downvote-button" data-downvote-url="{{ route('article.downvote', ['id' => $article->id]) }}">
                    @if($voteArticle == -1)
                        <i class='bx bxs-downvote'></i>
                    @else
                        <i class='bx bx-downvote'></i>
                    @endif
                </button>
                </div>
                </div>



                <div class="comments-section">
                    <h2>Comments</h2>
                    <form id="comment-form" class="comment" action="{{ route('article.writecomment', ['id' => $article->id]) }}">
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
                    <div class="comments-list">
                        @include('partials.comments', ['comments' => $comments, 'user' => $user, 'article' => $article])
                    </div>
                </div>
            </div>
        </section>
        <nav class="news-tab-section">
            @include('partials.trending_tags',['trendingTags' => $trendingTags])
            @include('partials.recent_news',['recentNews' => $recentNews])
        </nav>
    </div>

    <script src="{{ url('js/article_vote.js') }}" defer></script>


@endsection