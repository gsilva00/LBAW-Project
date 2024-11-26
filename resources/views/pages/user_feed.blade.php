@extends('layouts.app')

@section('title', 'User Feed')

@section('content')
    <br>
    <div class="recent-news-wrapper">
        <div class="feed-options-container" data-toggle="buttons">
            <label class="feed-option active" data-url="{{ route('followingTags') }}">
                <input type="radio" name="feed-options" checked> <i class='bx bx-purchase-tag'></i>Followed Tags
            </label>
            <label class="feed-option" data-url="{{ route('followingTopics') }}">
                <input type="radio" name="feed-options"><i class='bx bx-book'></i> Followed Topics
            </label>
            <label class="feed-option" data-url="{{ route('followingAuthors') }}">
                <input type="radio" name="feed-options"><i class='bx bx-heart'></i> Followed Authors
            </label>
        </div>
        <br>
        <div id="articles">
            <div class="recent-news-container">
                @foreach($articles as $article)
                    @include('partials.long_news_tile', [
                        'article' => $article,
                    ])
                @endforeach
            </div>
        </div>
    </div>
@endsection