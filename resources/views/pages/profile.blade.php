@extends('layouts.homepage')

@section('content')
    <div class="container">
        <h1>User Profile</h1>
        <p>Name: {{ $profileUsername }}</p>
        <p>Display Name: {{ $displayName }}</p>
        @if($isOwner)
            <a href="{{ route('profile', ['username' => $username]) }}"><button>Edit</button></a>
        @endif
    </div>
@endsection