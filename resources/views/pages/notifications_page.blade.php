@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
    <div class="recent-news-wrapper">
        <h1 class="large-rectangle"> Notifications</h1>
        <div class="search-comments-options-container" data-toggle="buttons">
            <label class="active" tabindex="0">
                <input type="radio" name="search-comment-options" id="new-tab" checked aria-controls="notificationTabsContent"> <i class='bx bx-sun'></i>New
            </label>
            <label tabindex="0">
                <input type="radio" name="search-comment-options" id="archived-tab" aria-controls="notificationTabsContent"> <i class='bx bx-box'></i>Archived
            </label>
        </div>

        <br>

        <div class="search-comments-options-container" data-toggle="buttons">
            <label class="active" tabindex="0">
                <input type="radio" name="search-comment-options" id="all-tab" checked aria-controls="notificationTabsContent"><i class='bx bx-collection'></i>All
            </label>
            <label tabindex="0">
                <input type="radio" name="search-comment-options" id="upvotes-tab" aria-controls="notificationTabsContent"> <i class='bx bx-sort'></i>Upvotes
            </label>
            <label tabindex="0">
                <input type="radio" name="search-comment-options" id="comments-tab" aria-controls="notificationTabsContent"><i class='bx bx-chat'></i>Comments
            </label>
        </div>
        <br>
        <div id="notificationTabsContent">
            @include('partials.notification_list', ['notifications' => $notifications])
        </div>
    </div>
@endsection

