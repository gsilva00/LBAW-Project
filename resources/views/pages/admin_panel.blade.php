@extends('layouts.homepage')

@section('content')
    <div class="recent-news-wrapper">
        <h1 class="large-rectangle">Admin Panel</h1>
        <h2 class="large-rectangle">Create New User</h2>
        <form class="large-rectangle" id="createFullUserForm" method="POST" action="{{ route('adminPanel.createUser') }}" enctype="multipart/form-data">
            @csrf
            <br>
            <div class="profile-info">
                <label for="username"><span>Username</span></label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" placeholder="Enter username" autocomplete="off" required>
            </div>
            @if ($errors->has('username'))
                @include('partials.error_popup', ['field' => 'username'])
            @endif
            <br>
            <div class="profile-info">
                <label for="email"><span>Email</span></label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Enter email" autocomplete="email" required>
            </div>
            @if ($errors->has('email'))
                @include('partials.error_popup', ['field' => 'email'])
            @endif
            <br>
            <div class="profile-info">
                <label for="display_name"><span>Display Name</span></label>
                <input type="text" name="display_name" id="display_name" value="{{ old('display_name') }}" placeholder="Enter display name" autocomplete="name">
            </div>
            <br>
            <div class="profile-info">
                <label for="description"><span>Description</span></label>
                <textarea name="description" id="description" placeholder="Enter description">{{ old('description') }}</textarea>
            </div>
            <br>
            <div class="profile-info">
                <label for="password"><span>Password</span></label>
                <input type="password" name="password" id="password" placeholder="Enter password" autocomplete="new-password" required>
            </div>
            <br>
            <p class="small-text">* Upload an image to change the current profile picture</p>
            <div class="profile-info">
                <label for="profile_picture"><span>Upload Profile Picture</span></label>
                <input type="file" name="profile_picture" id="profile_picture">
            </div>
            @if ($errors->has('profile_picture'))
                @include('partials.error_popup', ['field' => 'profile_picture'])
            @endif
            <br>
            <div class="profile-info">
                <label for="reputation"><span>Reputation (0-5)</span></label>
                <input type="number" name="reputation" id="reputation" value="{{ old('reputation', 3) }}" min="0" max="5">
            </div>
            @if ($errors->has('reputation'))
                @include('partials.error_popup', ['field' => 'reputation'])
            @endif
            <br>
            <div class="profile-info">
                <input type="checkbox" name="upvote_notification" id="upvote_notification" value="1" {{ old('upvote_notification', true) ? 'checked' : '' }}>
                <label for="upvote_notification"><span>Receive Upvote Notifications</span></label>
            </div>
            <br>
            <div class="profile-info">
                <input type="checkbox" name="comment_notification" id="comment_notification" value="1" {{ old('comment_notification', true) ? 'checked' : '' }}>
                <label for="comment_notification"><span>Receive Comment Notifications</span></label>
            </div>
            <br>
            <div class="profile-info">
                <input type="checkbox" name="is_admin" id="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }}>
                <label for="is_admin"><span>Is Admin</span></label>
            </div>
            <br>
            <div class="profile-info">
                <input type="checkbox" name="is_fact_checker" id="is_fact_checker" value="1" {{ old('is_fact_checker') ? 'checked' : '' }}>
                <label for="is_fact_checker"><span>Is Fact Checker</span></label>
            </div>
            <br>
            <br>
            <br>
            <div class="profile-info">
                <button type="submit" class="large-rectangle small-text greyer">Create</button>
            </div>
        </form>
        <br>
        <h2 class="large-rectangle">Users:</h2>
        <div id="users-section">
            <div id="user-list">
                @include('partials.user_tile_list', ['users' => $users])
            </div>
            @if($hasMorePages)
                <button id="see-more-users" data-page-num="{{ $currPageNum+1 }}" data-url="{{ route('more.users') }}">Load More</button>
            @endif
        </div>
        <div id="another-section">
            <!-- <h2>Another Section to prove the scroll is working</h2> -->
        </div>
    </div>
@endsection