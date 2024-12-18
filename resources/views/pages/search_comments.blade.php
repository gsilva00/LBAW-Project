@extends('layouts.app')

@section('title', 'Search')

@section('content')
    <div class="recent-news-wrapper">
        <h1 class="large-rectangle">Search Results</h1>
        <div class="large-rectangle">
            <p class="small-text">You searched for: {{ $searchQuery }}</p>
        </div>
        <ul class="nav nav-tabs" id="comments-search-Tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="comments-tab" data-bs-toggle="tab" data-bs-target="#new" type="button" role="tab" aria-controls="comments" aria-selected="true">Comments</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="replies-tab" data-bs-toggle="tab" data-bs-target="#archived" type="button" role="tab" aria-controls="replies" aria-selected="false">Replies</button>            </li>
        </ul>
        <div class="comments-grid" id="comments-searched">
            @include('partials.comment_list_searched', ['commentsItems' => $commentsItems, 'user' => $user, 'isReplies' => false])
        </div>
        <div class="replies-grid" id="replies-searched" style="display: none;">
            @include('partials.comment_list_searched', ['commentsItems' => $repliesItems, 'user' => $user, 'isReplies' => true])
        </div>
    </div>
@endsection