@extends('layouts.homepage')

@section('content')
    <div class="container mt-5">
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-secondary active" data-url="{{ route('followingTags') }}">
                <input type="radio" name="options" id="option1" autocomplete="off" checked> Followed Tags
            </label>
            <label class="btn btn-secondary" data-url="{{ route('followingTopics') }}">
                <input type="radio" name="options" id="option2" autocomplete="off"> Followed Topics
            </label>
            <label class="btn btn-secondary" data-url="{{ route('followingAuthors') }}">
                <input type="radio" name="options" id="option3" autocomplete="off"> Followed Authors
            </label>
        </div>

        <div id="articles" class="mt-4">
            <div class="recent-news-container">
                @foreach($articles as $article)
                    @include('partials.long_news_tile', [
                        'article' => $article,
                    ])
                @endforeach
            </div>
        </div>
    </div>
@endsection