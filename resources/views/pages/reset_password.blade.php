@extends('layouts.app')

@section('content')
    <div class="recover-password-container">
        <form method="POST" action="{{ route('resetPasswordAction') }}">
            {{ csrf_field() }}
            <h1>Recover Password</h1>
            <div class="">
                <label for="password"><span>New Password</span></label>
                <input id="password" type="password" name="password" required autofocus autocomplete="new-password" placeholder="password">
                <label for="confirm_password"><span>Confirm Password</span></label>
                <input id="confirm_password" type="password" name="confirm_password" required autofocus autocomplete="new-password" placeholder="confirm password">
                <input type="hidden" name="email" value="{{ session('email') }}">
            </div>
            <br>
            <div class="profile-info">
                <button type="submit" class="large-rectangle small-text">Reset Password</button>
            </div>
        </form>
    </div>
@endsection