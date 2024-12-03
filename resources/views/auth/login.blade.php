@extends('layouts.app')

@section('content')
    <div class="login-register-container">
        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <h1>Login</h1>
            <div class="profile-info space-between">
                <label for="email"><span>E-mail</span></label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       autocomplete="email">
            </div>
            @if ($errors->has('email'))
                @include('partials.error_popup', ['field' => 'email'])
            @endif
            <br>
            <div class="profile-info space-between">
                <label for="password"><span>Password</span></label>
                <input id="password" type="password" name="password" required>
                @if ($errors->has('password'))
                    @include('partials.error_popup', ['field' => 'password'])
                @endif
            </div>
            @if ($errors->has('password'))
                @include('partials.error_popup', ['field' => 'password'])
            @endif
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
            @include('partials.success_message')
            @if(session('error'))
                @include('partials.error_popup', ['field' => 'error'])
            @endif
        </form>
    </div>
@endsection