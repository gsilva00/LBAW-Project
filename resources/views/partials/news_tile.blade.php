<div class="news-tile">
    <a href="{{ route('article.show', ['id' => $article->id]) }}">
        <img src="{{ asset('images/article/' . $article->article_image) }}" alt="News Image">
        <p class="title">{{ $article->title }}</p>
    </a>
    @if(empty($noButtons) || !$noButtons)
    <div class="float-container">
        <a href="{{ route('editArticle', ['id' => $article->id]) }}" class="large-rectangle small-text"><span>Edit</span></a>
        <form action="{{ route('deleteArticle', ['id' => $article->id]) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="large-rectangle small-text greyer"><span>Delete</span></button>
        </form>    </div>
    @endif
</div>