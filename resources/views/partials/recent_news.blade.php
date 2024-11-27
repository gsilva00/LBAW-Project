<section id="recent-news-section">
    <a href="{{ route('showRecentNews') }}"><h2 class="title">Most Recent News</h2></a>
    @if($recentNews->isNotEmpty())
        <div class="{{ $isHomepage ? 'homepage-style' : ''}}">
            @foreach($recentNews as $article)
                @include('partials.news_tile', ['article' => $article])
            @endforeach
        </div>
    @else
        <p>No recent news available.</p>
    @endif
</section>