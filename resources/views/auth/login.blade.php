@extends('layouts.app')

@section('content')
    <div class="login-register-container">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <h1>Login</h1>
            <div class="profile-info space-between">
                <label for="login"><span>Email/Username</span></label>
                <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus autocomplete="username" placeholder="email/username">
            </div>
            <br>
            <div class="profile-info space-between">
                <label for="password"><span>Password</span></label>
                <input id="password" type="password" name="password" required>
            </div>
            <br>
            <div class="profile-info">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember"><span>Remember Me</span></label>
            </div>
            <br>
            <div class="profile-info">
                <button type="submit" class="large-rectangle small-text">
                    Login
                </button>
                <a class="large-rectangle small-text" href="{{ route('register') }}">Register</a>
            </div>
            <br>
            <div class="Recover Password">
                <a href="{{ route('recoverPasswordForm') }}">Forgot Your Password?</a>
            </div>
        </form>
    </div>
@endsection