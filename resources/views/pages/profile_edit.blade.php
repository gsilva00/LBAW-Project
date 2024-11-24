@extends('layouts.homepage')

@section('content')
    <div class="profile-wrapper">
        <h1 class="large-rectangle">Edit User Profile</h1>
        <section class="profile-container">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                <br>
                <h2><strong>General Profile Information</strong></h2>
                <div class="profile-info">
                    <label for="username"><span>Username</span></label>
                    <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" autocomplete="off">
                    @if ($errors->has('username'))
                        <span class="error">
                            {{ $errors->first('username') }}
                        </span>
                    @endif
                </div>
                <br>
                <div class="profile-info">
                    <label for="email"><span>Email</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" autocomplete="email">
                    @if ($errors->has('email'))
                        <span class="error">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>
                <br>
                <div class="profile-info">
                    <label for="display_name"><span>Display Name</span></label>
                    <input type="text" name="display_name" id="display_name" value="{{ old('display_name', $user->display_name) }}" autocomplete="name">
                </div>
                <br>
                <div class="profile-info">
                    <label for="description"><span>Description</span></label>
                    <input type="text" name="description" id="description" value="{{ old('description', $user->description) }}">
                </div>
                <br>
                <p class="small-text">* Upload an image to change the current profile picture</p>
                <div class="profile-info">
                    <label for="profile_picture"><span>Upload Profile Picture</span></label>
                    <input type="file" name="profile_picture" id="profile_picture">
                    @if ($errors->has('profile_picture'))
                        <span class="error">
                            {{ $errors->first('profile_picture') }}
                        </span>
                    @endif
                </div>
                <br>
                <p class="small-text">* Write password to confirm any changes to profile</p>
                <div class="profile-info">
                    <label for="cur_password"><span>Current Password</span></label>
                    <input type="password" name="cur_password" id="cur_password" placeholder="password">
                    @if ($errors->has('cur_password'))
                        <span class="error">
                            {{ $errors->first('cur_password') }}
                        </span>
                    @endif
                </div>
                <br>
                <h2><strong>Optional: Change Password</strong></h2>
                <div class="profile-info">
                    <label for="new_password"><span>New Password</span></label>
                    <input type="password" name="new_password" id="new_password" placeholder="new password">
                    @if ($errors->has('new_password'))
                        <span class="error">
                            {{ $errors->first('new_password') }}
                        </span>
                    @endif
                </div>
                <br>
                <div class="profile-info">
                    <label for="new_password_confirmation"><span>Confirm Password</span></label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="new password">
                    @if ($errors->has('new_password_confirmation'))
                        <span class="error">
                            {{ $errors->first('new_password_confirmation') }}
                        </span>
                    @endif
                </div>
                <br>
                <br>
                <br>
                <br>
                <div class="profile-info">
                    <span>Don't forget to save after alterations:</span>
                    <button type="submit" class="large-rectangle small-text greyer">Save</button> <!-- TODO HIGHLIGHT IN RED IF PASSWORD NOT INPUTTED (HARD TO SEE OTHERWISE) -->
                </div>
            </form>
            </section>
            <section class="profile-container">
            <form>
                @csrf
                <br>
                <h2><strong>Delete account</strong></h2>
                @if($isOwner)
                <p>Write password to erase your account and then press "Delete This Account"</p>
                <div class="profile-info">
                    <label for="cur_password_delete"><span>Current Password</span></label>
                    <input type="password" name="cur_password_delete" id="cur_password_delete" placeholder="password">
                    @if ($errors->has('cur_password'))
                        <span class="error">
                            {{ $errors->first('cur_password') }}
                        </span>
                    @endif
                </div>
                @endif
                <br>
                <div class="profile-info">
                    <span>Do you want to erase this account?</span>
                    <form action="{{ route('profile.delete', ['id' => $user->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE') <!-- HTML forms don't directly support DELETE -->
                        <button type="submit" class="large-rectangle small-text greyer">Delete This Account</button>
                    </form>
                </div>
                <br>
            </form>
        </section>
    </div>
@endsection