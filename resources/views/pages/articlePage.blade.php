@extends('layouts.homepage')

@section('content')
    <div class="breadcrumb">
        <a href="{{ $previousUrl }}">{{ $previousPage }}</a> >
        <span>{{ $topic->name }}</span> >
        <span>{{ $article->title }}</span>
    </div>
    <div class="news-article">
        <h1>{{ $article->title }}</h1>
        <p><strong>Created Date: </strong> {{ $article->create_date }}</p>
        <p><strong>Edited Date: </strong>
            @if($article->is_edited)
                {{ $article->edit_date }}
            @else
                No edition yet
            @endif
        </p>
        <p><strong>Subtitle: </strong> {{ $article->subtitle }}</p>
        <p><strong>Content: </strong>{{ $article->content }}</p>
        <p><strong>Author:</strong> {{ $authorDisplayName }}</p>
        <p><strong>Topic:</strong> {{ $topic->name }}</p>
        <p><strong>Tags:</strong>
            @foreach($tags as $tag)
                <span>{{ $tag->name }}</span>@if(!$loop->last), @endif
            @endforeach
        </p>
        <div class="image-box">
            <img src="https://picsum.photos/seed/picsum/200/300" alt="News Image" width="200" height="300">
        </div>
    </div>
@endsection