@extends('layouts.app')

@section('title', 'Recover Password')

@section('content')
    @if(session('status'))
        @if(session('status') === 'Success!')
            <form method="POST" action="{{ route('resetPasswordCheck') }}">
                @csrf
                <h1>{{ session('message') }}</h1>
                <div class="">
                    <label for="code"><span>Verification Code</span></label>
                    <input id="code" type="text" name="code" value="{{ old('code') }}" required autofocus autocomplete="code" placeholder="code">
                </div>
                <input type="hidden" name="real_code" value="{{ session('verificationCode') }}">
                <input type="hidden" name="email" value="{{ session('email') }}">
                <br>
                <div class="profile-info">
                    <button type="submit" class="large-rectangle small-text">Confirm</button>
                </div>
            </form>
        @else
            <h3>{{ session('status') }}</h3>
            <h4>{{ session('message') }}</h4>
            <button onclick="location.reload()">
                <h3>Try again</h3>
            </button>
        @endif
    @else
        <div class="recover-password-container">
            <form method="POST" action="{{ route('recoverPasswordAction') }}">
                @csrf
                <h1>Recover Password</h1>
                <div class="">
                    <label for="email"><span>Email</span></label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="email">
                </div>
                <br>
                <div class="profile-info">
                    <button type="submit" class="large-rectangle small-text">Recover Password</button>
                </div>
            </form>
        </div>
    @endif
@endsection