<div class="recent-news-container">
    @foreach($articles as $article)
        @include('partials.long_news_tile', [
            'article' => $article,
        ])
    @endforeach
</div>