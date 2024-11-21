@extends('layouts.homepage')

@section('content')
    <div class="container">
        <h1>Edit User Profile</h1>
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            <label for="username">Username</label>
            <input type="text" name="username" value="{{ old('username', $username) }}">
            @if ($errors->has('username'))
                <span class="error">
                    {{ $errors->first('username') }}
                </span>
            @endif

            <br>

            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email', $email) }}">
            @if ($errors->has('email'))
                <span class="error">
                    {{ $errors->first('email') }}
                </span>
            @endif

            <br>

            <label for="display_name">Display Name</label>
            <input type="text" name="display_name" value="{{ old('display_name', $displayName) }}">

            <br>

            <label for="description">Description</label>
            <input type="text" name="description" value="{{ old('description', $description) }}">

            <br>

            <label for="cur_password">Current Password</label>
            <input type="password" name="cur_password">
            @if ($errors->has('cur_password'))
                <span class="error">
                    {{ $errors->first('cur_password') }}
                </span>
            @endif

            <br>

            <label for="new_password">New Password</label>
            <input type="password" name="new_password">
            @if ($errors->has('new_password'))
                <span class="error">
                    {{ $errors->first('new_password') }}
                </span>
            @endif

            <br>

            <label for="new_password_confirmation">Confirm Password</label>
            <input type="password" name="new_password_confirmation">
            @if ($errors->has('new_password_confirmation'))
                <span class="error">
                    {{ $errors->first('new_password_confirmation') }}
                </span>
            @endif

            <br>

            <label for="profile_picture">Upload Profile Picture</label>
            <input type="file" name="profile_picture">
            @if ($errors->has('profile_picture'))
                <span class="error">
                    {{ $errors->first('profile_picture') }}
                </span>
            @endif

            <br>

            <button type="submit">Save</button>
        </form>
    </div>
@endsection