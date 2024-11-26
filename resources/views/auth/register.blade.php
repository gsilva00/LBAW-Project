@extends('layouts.app')

@section('content')
    <div class="login-register-container">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h1>Register</h1>
            <div class="profile-info space-between">
                <label for="Username"><span>Username</span></label>
                <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus
                       autocomplete="off">
                @if ($errors->has('username'))
                    @include('partials.error_popup', ['field' => 'username'])
                @endif
            </div>
            <br>
            <div class="profile-info space-between">
                <label for="email"><span>E-Mail</span></label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                @if ($errors->has('email'))
                    @include('partials.error_popup', ['field' => 'email'])
                @endif
            </div>
            <br>
            <div class="profile-info space-between">
                <label for="password"><span>Password</span></label>
                <input id="password" type="password" name="password" required>
                @if ($errors->has('password'))
                    @include('partials.error_popup', ['field' => 'password'])
                @endif
            </div>
            <br>
            <div class="profile-info space-between">
                <label for="password-confirm"><span>Confirm Password</span></label>
                <input id="password-confirm" type="password" name="password_confirmation" required>
            </div>
            <br>
            <div class="profile-info">
                <button type="submit" class="large-rectangle small-text">
                    Register
                </button>
                <a class="large-rectangle small-text" href="{{ route('login') }}">Login</a>
            </div>
        </form>
    </div>
@endsection