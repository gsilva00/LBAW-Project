@extends('layouts.app')

@section('title', 'Search')

@section('content')
    <div class="recent-news-wrapper">
        <h1 class="large-rectangle">Comment Search Results</h1>
        <div class="large-rectangle">
            <p class="small-text">You searched for: {{ $searchQuery }}</p>
        </div>
        <br>
        <div class="search-comments-options-container" data-toggle="buttons">
            <label class="active" tabindex="0">
                <input type="radio" name="search-comment-options" id="comments-tab" checked aria-controls="comments-searched"> <i class='bx bx-chat'></i>Comments
            </label>
            <label tabindex="0">
                <input type="radio" name="search-comment-options" id="replies-tab" aria-controls="replies-searched"> <i class='bx bx-conversation'></i>Replies
            </label>
        </div>

        <div class="comments-grid" id="comments-searched">
            @include('partials.comment_list_searched', ['commentsItems' => $commentsItems, 'user' => $user, 'isReplies' => false])
        </div>
        <div class="replies-grid" id="replies-searched" style="display: none;">
            @include('partials.comment_list_searched', ['commentsItems' => $repliesItems, 'user' => $user, 'isReplies' => true])
        </div>
    </div>
@endsection