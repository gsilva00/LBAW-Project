@extends('layouts.homepage')

@section('content')
    <div class="container">
        <h1>User Profile</h1>
        <p>Name: {{ $profileUsername }}</p>
        <p>Display Name: {{ $displayName }}</p>
        <p>Description: {{ $description }}</p>
        @if($isOwner)
            <a href="{{ route('profile.edit')}}"><button>Edit</button></a>
        @endif
    </div>
@endsection