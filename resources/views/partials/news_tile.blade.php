<div class="news-tile">
    <a href="{{ route('article.show', ['id' => $article->id]) }}">
        <img src="{{ asset('images/article/' . $article->article_image) }}" alt="News Image">
        <p class="title">{{ $article->title }}</p>
    </a>
</div>