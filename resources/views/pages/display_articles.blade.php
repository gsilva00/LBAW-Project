@extends('layouts.homepage')

@section('content')
    <div class="articles-wrapper">
        @foreach($articles as $article)
            @include('partials.news_tile', ['article' => $article])
        @endforeach
    </div>
@endsection



