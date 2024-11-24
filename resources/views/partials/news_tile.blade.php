<div class="news-tile">
    <a href="{{ route('article.show', ['id' => $article->id]) }}">
        <img src="{{ asset('images/article/' . $article->article_image) }}" alt="News Image">
        <p class="title">{{ $article->title }}</p>
    </a>
    @if(!$article->is_deleted)
    <div class="float-container">
    <button class="large-rectangle small-text"><span>Edit</span></button>
    <button class="large-rectangle small-text greyer"><span>Delete</span></button>
    </div>
    @endif
</div>