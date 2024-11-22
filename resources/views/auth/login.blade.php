@extends('layouts.homepage')

@section('content')
<div class="profile-wrapper login-register-container">
<form method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}
    <h1>Login</h1>
    <div class="profile-info space-between">
    <label for="email"><span>E-mail</span></label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email">
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
    @endif
    </div>
    <br>
    <div class="profile-info space-between">
    <label for="password" ><span>Password</span></label>
    <input id="password" type="password" name="password" required>
    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif
    </div>
    <br>
    <div class="profile-info">
        <input type="checkbox" name="remember" id="rebember" {{ old('remember') ? 'checked' : '' }}>
        <label for="rebember"><span>Remember Me</span></label>
    </div>
    <br>
    <div class="profile-info">
    <button type="submit" class="large-rectangle small-text">
        Login
    </button>
    <a class="large-rectangle small-text" href="{{ route('register') }}">Register</a>
    </div>
    <br>
    @if (session('success'))
        <p class="success">
            {{ session('success') }}
        </p>
    @endif
    </div>
</form>
</div>
@endsection