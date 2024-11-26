@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="profile-wrapper">
        <h1 class="large-rectangle">Edit User Profile</h1>
        <section class="profile-container">
            <form method="POST" action="{{ route('updateProfile', ['username' => $profileUser->username]) }}" enctype="multipart/form-data">
                @csrf
                <br>
                <h2><strong>General Profile Information</strong></h2>
                <div class="profile-info">
                    <label for="username"><span>Username</span></label>
                    <input type="text" name="username" id="username" value="{{ $profileUser->username }}" autocomplete="off" disabled>
                    <input type="hidden" name="username" value="{{ $profileUser->username }}">
                    <!-- So that the username value is actually submitted (disabled inputs aren't submitted) -->
                </div>
                @if ($errors->has('username'))
                    @include('partials.error_popup', ['field' => 'username'])
                @endif
                <br>
                <div class="profile-info">
                    <label for="email"><span>Email</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $profileUser->email) }}" autocomplete="email">
                </div>
                @if ($errors->has('email'))
                    @include('partials.error_popup', ['field' => 'email'])
                @endif
                <br>
                <div class="profile-info">
                    <label for="display_name"><span>Display Name</span></label>
                    <input type="text" name="display_name" id="display_name" value="{{ old('display_name', $profileUser->display_name) }}" autocomplete="name">
                </div>
                <br>
                <div class="profile-info">
                    <label for="description"><span>Description</span></label>
                    <input type="text" name="description" id="description" value="{{ old('description', $profileUser->description) }}">
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
                @if ($user->is_admin && !$isOwner)
                    <p class="small-text">* Admins don't need to confirm the password to make any changes to the profile</p>
                    <div class="profile-info">
                        <label for="cur_password"><span>Current Password</span></label>
                        <input type="password" name="cur_password" id="cur_password" value="********" disabled>
                    </div>
                @else
                    <p class="small-text">* Write password to confirm any changes to the profile</p>
                    <div class="profile-info">
                        <label for="cur_password"><span>Current Password</span></label>
                        <input type="password" name="cur_password" id="cur_password" placeholder="Password">
                    </div>
                    @if ($errors->has('cur_password'))
                        @include('partials.error_popup', ['field' => 'cur_password'])
                    @endif
                @endif
                <br>
                <h2><strong>Optional: Change Password</strong></h2>
                <div class="profile-info">
                    <label for="new_password"><span>New Password</span></label>
                    <input type="password" name="new_password" id="new_password" placeholder="New Password">
                </div>
                @if ($errors->has('new_password'))
                    @include('partials.error_popup', ['field' => 'new_password'])
                @endif
                <br>
                <div class="profile-info">
                    <label for="new_password_confirmation"><span>Confirm Password</span></label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="New Password">
                </div>
                @if ($errors->has('new_password_confirmation'))
                    @include('partials.error_popup', ['field' => 'new_password_confirmation'])
                @endif
                <br>
                <br>
                <br>
                <br>
                <div class="profile-info">
                    <span>Don't forget to save after alterations:</span>
                    <button type="submit" class="large-rectangle small-text greyer">Save</button>
                </div>
            </form>
        </section>
        <section class="profile-container">
            <form action="{{ route('deleteProfile', ['id' => $profileUser->id]) }}" method="POST" style="display:inline;">
            @csrf
                <br>
                <h2><strong>Delete account</strong></h2>
                @if($isOwner)
                    <p>Write password to erase your account and then press "Delete This Account"</p>
                    <div class="profile-info">
                        <label for="cur_password_delete"><span>Current Password</span></label>
                        <input type="password" name="cur_password_delete" id="cur_password_delete" placeholder="password">
                    </div>
                    @if ($errors->has('cur_password_delete'))
                        @include('partials.error_popup', ['field' => 'cur_password_delete'])
                    @endif
                @endif
                <br>
                <div class="profile-info">
                    <span>Do you want to erase this account?</span>
                    <button type="submit" class="large-rectangle small-text greyer">Delete This Account</button>
                </div>
                <br>
            </form>
        </section>
    </div>
@endsection