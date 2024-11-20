@extends('layouts.homepage')

@section('content')
    <div class="breadcrumb">
        <a href="{{ $previousUrl }}">{{ $previousPage }}</a> >
        <span>{{ $topic->name }}</span> >
        <span>{{ $article->title }}</span>
    </div>
    <div class="news-article">
        <h1>{{ $article->title }}</h1>
        <p>{{ $article->content }}</p>
        <p><strong>Author:</strong> {{ $authorDisplayName }}</p>
        <p><strong>Topic:</strong> {{ $topic->name }}</p>
        <p><strong>Tags:</strong>
            @foreach($tags as $tag)
                <span>{{ $tag->name }}</span>@if(!$loop->last), @endif
            @endforeach
        </p>
    </div>
@endsection