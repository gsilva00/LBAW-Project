@extends('layouts.homepage')

@section('content')
    <h1>Welcome {{ $username ?? 'Guest' }}</h1>
    @if(Auth::check())
        <form class="button" action="{{ route('logout') }}" method="GET">
            @csrf
            <button type="submit">Logout</button>
        </form>
    @else
        <a class="button" href="{{ route('login') }}">
            <button type="button">Login</button>
        </a>
    @endif
@endsection
