@extends('layouts.app')

@section('title', 'Search')

@section('content')
    <div class="recent-news-wrapper">
        <h1 class="large-rectangle">Search Results</h1>
        <div class="large-rectangle">
            <p class="small-text">You searched for: {{ $searchQuery }}</p>
        </div>

        @if($usersItems->isEmpty())
            <p>No Users found.</p>
        @else
            <div class="news-grid">
                @foreach($usersItems as $userItem)
                    @include('partials.user_tile', ['user' => $userItem])
                @endforeach
            </div>
        @endif
    </div>
@endsection