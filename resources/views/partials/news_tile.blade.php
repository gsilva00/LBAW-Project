<div class="news-tile">
    <a href="{{ route('showArticle', ['id' => $article->id]) }}">
        <img src="{{ asset('images/article/' . $article->article_image) }}" alt="Article's main image">
        <p class="title">{{ $article->title }}</p>
    </a>
    @if(!$article->is_deleted && Auth::check() && Auth::user()->id === $article->author_id)
        <div class="float-container">
            <a href="{{ route('editArticle', ['id' => $article->id]) }}" class="large-rectangle small-text"><span>Edit</span></a>
            <form action="{{ route('deleteArticle', ['id' => $article->id]) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="large-rectangle small-text greyer"><span>Delete</span></button>
            </form>
        </div>
    @endif
</div>