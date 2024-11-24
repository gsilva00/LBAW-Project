@extends('layouts.homepage')

@section('title', 'Edit Article')

@section('content')
    <h1>Create a New Article</h1>
    <form action="{{ route('updateArticle', ['id' => $article->id]) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $article->title }}" required>
        </div>
        <div class="mb-3">
            <label for="subtitle" class="form-label">Subtitle</label>
            <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ $article->subtitle }}" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="10" required>{{ $article->content }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
@endsection