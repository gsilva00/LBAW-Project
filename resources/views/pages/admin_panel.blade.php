@extends('layouts.homepage')

@section('content')
    <div class="content">
        <div id="users-section" style="height: 800px; overflow-y: scroll;"> <!-- Make the height 2 or 3 users, or more if the user cards are made shorter -->
            <h2>Users:</h2>
            <a href="#" class="btn btn-primary">Add User</a> <!-- Takes too add user page -->
            <br>
            <ul id="user-list">
                @include('partials.user_tile_list', ['users' => $users])
            </ul>
            @if($hasMorePages)
                <button id="see-more-users" data-page-num="{{ $currPageNum+1 }}" data-url="{{ route('more.users') }}">Load More</button>
            @endif
        </div>
        <div id="another-section">
            <h2>Another Section to prove the scroll is working</h2>
        </div>
    </div>
@endsection