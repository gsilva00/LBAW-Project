@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content')
    <div class="recent-news-wrapper">
        <h1 class="large-rectangle">Administrator Panel</h1>
        <h2 class="large-rectangle">Create New User</h2>
        @include('partials.create_user_form')
        <br>
        <h2 class="large-rectangle">List of User Accounts</h2>
        <div id="users-section">
            <div id="user-list">
                @include('partials.user_tile_list', ['users' => $users])
            </div>
            @if($hasMorePages)
                <button id="see-more-users" data-page-num="{{ $currPageNum+1 }}" data-url="{{ route('moreUsers') }}">Load More</button>
            @endif
        </div>
        <br>
        <h2 class="large-rectangle">Create a New Topic</h2>
        <div id="another-section">

        </div>
        <br>
        <h2 class="large-rectangle">Create a New Tag</h2>
        <div id="another-section">

        </div>
        <br>
        <h2 class="large-rectangle">List of Pending Tag Proposals</h2>
        <div id="another-section">

        </div>
        <br>
        <h2 class="large-rectangle">List of Pending Unban Appeals</h2>
        <div id="another-section">

        </div>
        <br>
        <h2 class="large-rectangle">List of Pending Fact Checker Requests</h2>
        <div id="another-section">
            <!-- TODO maybe -->
        </div>
    </div>
@endsection