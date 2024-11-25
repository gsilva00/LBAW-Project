@extends('layouts.homepage')

@section('content')
<div class="recent-news-wrapper">
    <h1 class="large-rectangle">Trending Tags</h1>
    <nav id="trending-tags-section">
        @foreach($trendingTags as $tag)
            <p class="smaller-text">{{ $loop->iteration }} Trending</p>
            <span><strong><a href="{{ route('tag.show', ['name' => $tag->name]) }}">{{ $tag->name }}</a></strong> ({{ $tag->articles_count }} articles)</span>
        @endforeach
    </nav>
</div>
@endsection