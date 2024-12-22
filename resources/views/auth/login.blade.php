@extends('layouts.app')

@section('content')
    <div class="login-register-container">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <br>
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
            <div class="Recover Password">
                <br>
                <a href="{{ route('recoverPasswordForm') }}" class="small-text">Forgot Your Password?</a>
            </div>
            <br>
            <div class="profile-info">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember"><span>Remember Me</span></label>
            </div>
            <br>
            <button type="submit" class="large-rectangle small-text">
                Login
            </button>
            <br>
            <br>
        </form>
    </div>
    <div class="login-register-container">
        <div class="profile-info">
            <p>Don't have an account yet?</p>
            <a class="large-rectangle small-text" href="{{ route('register') }}">Register</a>
        </div>
    </div>
@endsection