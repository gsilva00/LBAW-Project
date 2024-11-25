@extends('layouts.homepage')

@section('content')
    <div class="content">
        <h2>Users:</h2>
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            <h3>Create New User</h3>
            <div class="profile-info">
                <label for="username"><span>Username</span></label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" placeholder="Enter username" autocomplete="off" required>
            </div>
            @if ($errors->has('username'))
                <br>
                <div class="profile-info">
                    <span class="error">
                        {{ $errors->first('username') }}
                    </span>
                </div>
            @endif
            <br>
            <div class="profile-info">
                <label for="email"><span>Email</span></label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Enter email" autocomplete="email" required>
            </div>
            @if ($errors->has('email'))
                <br>
                <div class="profile-info">
                    <span class="error">
                    {{ $errors->first('email') }}
                    </span>
                </div>
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
                <br>
                <div class="profile-info">
                    <span class="error">
                        {{ $errors->first('profile_picture') }}
                    </span>
                </div>
            @endif
            <br>
            <div class="profile-info">
                <label for="reputation"><span>Reputation (0-5)</span></label>
                <input type="number" name="reputation" id="reputation" value="{{ old('reputation', 3) }}" min="0" max="5">
            </div>
            @if ($errors->has('reputation'))
                <br>
                <div class="profile-info">
                <span class="error">
                    {{ $errors->first('reputation') }}
                </span>
                </div>
            @endif
            <br>
            <div class="profile-info">
                <label for="upvote_notification">
                    <input type="checkbox" name="upvote_notification" id="upvote_notification" {{ old('upvote_notification', true) ? 'checked' : '' }}>
                    <span>Receive Upvote Notifications</span>
                </label>
            </div>
            <br>
            <div class="profile-info">
                <label for="comment_notification">
                    <input type="checkbox" name="comment_notification" id="comment_notification" {{ old('comment_notification', true) ? 'checked' : '' }}>
                    <span>Receive Comment Notifications</span>
                </label>
            </div>
            <br>
            <div class="profile-info">
                <label for="is_admin">
                    <input type="checkbox" name="is_admin" id="is_admin" {{ old('is_admin') ? 'checked' : '' }}>
                    <span>Is Admin</span>
                </label>
            </div>
            <br>
            <div class="profile-info">
                <label for="is_fact_checker">
                    <input type="checkbox" name="is_fact_checker" id="is_fact_checker" {{ old('is_fact_checker') ? 'checked' : '' }}>
                    <span>Is Fact Checker</span>
                </label>
            </div>
            <br>
            <div class="profile-info">
                <button type="submit" class="large-rectangle small-text greyer">Create</button> <!-- TODO HIGHLIGHT IN RED IF PASSWORD NOT INPUTTED (HARD TO SEE OTHERWISE) -->
            </div>
        </form>
        <br>
        <div id="users-section" style="height: 800px; overflow-y: scroll;"> <!-- Make the height 2 or 3 users, or more if the user cards are made shorter -->
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