@extends('layouts.homepage')

@section('content')
<div class="recent-news-wrapper">
        <h1 class="large-rectangle">Followed topics</h1>
        <div class="profile-info border-bottom">
            @if(count($followedtopics) == 0)
                <h2>You are not following any topics yet.</h2>
            @else
                @foreach($followedtopics as $topic)
                    <div class="topic">
                        <a href="{{ route('topic.show', ['name' => $topic->name]) }}">
                            <h2>{{ $topic->name }}</h2>
                        </a>
                        <p>{{ $topic->description }}</p>
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

