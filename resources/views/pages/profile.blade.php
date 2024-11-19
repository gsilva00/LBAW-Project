@extends('layouts.homepage')

@section('content')
    <div class="container">
        <h1>User Profile</h1>
        <p>Name: {{ $username }}</p>
        <p>Email: {{ $usermail }}</p>
        <!-- Add more user profile information here -->
    </div>
@endsection