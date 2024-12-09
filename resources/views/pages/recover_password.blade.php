@extends('layouts.app')

@section('content')
    @if(session('status'))
        <section class="content">
            <h3>{{ session('status') }}</h3>
            <h4>{{ session('message') }}</h4>
            <button onclick="location.reload()">
                <h3>Try again</h3>
            </button>
        </section>
    @else
        <div class="recover-password-container">
            <form method="POST" action="{{ route('recoverPasswordAction') }}">
                {{ csrf_field() }}
                <h1>Recover Password</h1>
                <div class="">
                    <label for="email"><span>Email</span></label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="email">
                </div>
                <br>
                <div class="profile-info">
                    <button type="submit" class="large-rectangle small-text">Recover Password</button>
                </div>
                <br>
            </form>
        </div>
    @endif
@endsection