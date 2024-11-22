@extends('layouts.homepage')

@section('content')
<div class="profile-wrapper login-register-container">
<form method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}
    <h1>Register</h1>
    <div class="profile-info space-between">
    <label for="Username"><span>Username</span></label>
    <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus autocomplete="off">
    @if ($errors->has('username'))
      <span class="error">
          {{ $errors->first('username') }}
      </span>
    @endif
    </div>
    <br>
    <div class="profile-info space-between">
    <label for="email"><span>E-Mail</span></label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
    @if ($errors->has('email'))
      <span class="error">
          {{ $errors->first('email') }}
      </span>
    @endif
    </div>
    <br>
    <div class="profile-info space-between">
    <label for="password"><span>Password</span></label>
    <input id="password" type="password" name="password" required>
    @if ($errors->has('password'))
      <span class="error">
          {{ $errors->first('password') }}
      </span>
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