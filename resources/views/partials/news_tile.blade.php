<div class="news-tile">
    <a href="{{ route('showArticle', ['id' => $article->id]) }}">
        <img src="{{ asset('images/article/' . $article->article_image) }}" alt="{{ $article->title }}'s main image">
        <p class="title">{{ $article->title }}</p>
    </a>
    @if(!$article->is_deleted && Auth::check() && Auth::user()->id === $article->author_id)
        <div class="float-container">
            <button type="button" class="large-rectangle small-text greener" onclick="window.location='{{ route('editArticle', ['id' => $article->id]) }}'">Edit</button>
            <form action="{{ route('deleteArticle', ['id' => $article->id]) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="large-rectangle small-text greener">Delete</button>
            </form>
        </div>
    @endif
</div>