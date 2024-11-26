@extends('layouts.app')

@section('title', 'Trending Tags')

@section('content')
    <div class="recent-news-wrapper">
        <h1 class="large-rectangle">Trending Tags</h1>
        <nav id="trending-tags-section">
            @foreach($trendingTags as $tag)
                <p class="smaller-text">{{ $loop->iteration }} Trending</p>
                <span><strong><a href="{{ route('showTag', ['name' => $tag->name]) }}">{{ $tag->name }}</a></strong> ({{ $tag->articles_count }} articles)</span>
            @endforeach
        </nav>
    </div>
@endsection