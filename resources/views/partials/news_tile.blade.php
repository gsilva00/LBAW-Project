<div class="news-tile">
    <a href="{{ route('article.show', ['id' => $article->id]) }}">
        <img src="https://picsum.photos/seed/picsum/200/300" alt="News Image" style="width: 100%; height: auto;">
        <h2>{{ $article->title }}</h2>
    </a>
</div>