<div class="border-bottom">
    <a href="{{ route('article.show', ['id' => $article->id]) }}">
    <img id="first-image" src="https://picsum.photos/seed/picsum/1200/1300" alt="News Image">
    <div class="news-article">
        <span class="article-title" >{{ $article->title }}</span>
        <span>{{ $article->subtitle }}</span>
    </div>
    </a>
</div>