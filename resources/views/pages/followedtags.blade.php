@extends('layouts.homepage')

@section('content')
<div class="recent-news-wrapper">
        <h1 class="large-rectangle">Followed tags</h1>
        <div class="profile-info border-bottom">
            @if(count($followedtags) == 0)
                <h2>You are not following any tags yet.</h2>
            @else
                @foreach($followedtags as $tag)
                    <div class="tag">
                        <a href="{{ route('tag.show', ['name' => $tag->name]) }}">
                            <h2>#{{ $tag->name }}</h2>
                        </a>
                        <p>{{ $tag->description }}</p>
                    </div>
                @endforeach
            @endif
        </div>
        <br>
        <section class="recent-news-container">
        @foreach($articles as $article)
            @include('partials.long_news_tile', [
                'article' => $article,
            ])
            @endforeach
        </section>
    </div>
@endsection

