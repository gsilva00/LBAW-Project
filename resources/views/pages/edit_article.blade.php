@extends('layouts.homepage')

@section('title', 'Edit Article')

@section('content')
    <script src="{{ url('js/tageditarticle.js') }}"> </script>

    <div class="profile-wrapper">
        <h1 class="large-rectangle">Edit a New Article</h1>
    <form class="large-rectangle" action="{{ route('updateArticle', ['id' => $article->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <br>
        <div class="profile-info">
            <label for="title"><span>Title</span></label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $article->title }}" placeholder="title" required>
        </div>
        <br>
        <div class="profile-info">
            <label for="subtitle"><span>Subtitle</span></label>
            <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ $article->subtitle }}" placeholder="subtitle" required>
        </div>
        <br>
        <div class="profile-info">
            <label for="content"><span>Content</span></label>
            <textarea class="form-control" id="content" name="content" rows="10" placeholder="content" required>{{ $article->content }}</textarea>
        </div>
        <br>
        <div class="profile-info">
                    <label for="tag-create-article-input"><span>Tags</span></label>
                    <input type="text" id="tag-create-article-input" placeholder="Type to search tags...">
                    <div id="tag-create-article-suggestions" class="suggestions"></div>
                </div>
                <div id="selected-create-article-tags" class="selected"></div>
                <div class="profile-info">
                    <label for="content"><span>Topics</span></label>
                    <select class="form-control" id="topics" name="topics[]" required>
                        <option value="No_Topic" {{ $article->topic_id == 'No_Topic' ? 'selected' : '' }}>No Topic</option>
                        @foreach($topics as $topic)
                            <option value="{{ $topic->id }}" {{ $article->topic_id == $topic->id ? 'selected' : '' }}>{{ $topic->name }}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                <div class="profile-info">
                    <label for="article_picture"><span>Upload Article Picture</span></label>
                    <input type="file" name="article_picture" id="article_picture">
                </div>
                @if ($errors->has('article_picture'))
                    @include('partials.error_popup', ['field' => 'article_picture'])
                @endif
                <br>
                <br>
                <br>
                <div class="profile-info">
                    <span>Save your article before leaving: </span>
                    <button type="submit" class="large-rectangle small-text greyer">Save Changes</button>
                </div>
                <br>
    </form>
</div>
<br>
<br>
<script>
    window.initialTags = @json($article->tags);
</script>
@endsection