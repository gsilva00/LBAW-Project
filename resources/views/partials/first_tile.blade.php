<div class="border-bottom">
    <a href="{{ route('showArticle', ['id' => $article->id]) }}">
        <img class="article-image" src="{{ asset('images/article/' . $article->article_image) }}" alt="Article's main image">
        <div class="news-article">
            <span class="article-title" >{{ $article->title }}</span>
            <span>{{ $article->subtitle }}</span>
        </div>
    </a>
</div>