@extends('layouts.homepage')

@section('content')
    <div class="sidebar">
        <ul>
            <li><a href="#" id="users-tab" class="active">Users</a></li>
            <!-- Other tabs can be added here -->
        </ul>
    </div>
    <div class="content">
        <div id="tab-content">
            <div id="users-content">
                <h2>Users:</h2>
                <ul id="user-list">
                    @include('partials.user_tile_list', ['users' => $users])
                </ul>
                @if($hasMorePages)
                    <button id="see-more-users" data-page-num="{{ $currPageNum+1 }}" data-url="{{ route('more.users') }}">Load More</button>
                @endif
            </div>
        </div>
    </div>
@endsection