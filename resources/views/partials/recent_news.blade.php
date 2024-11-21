<section id="recent-news-section">
<p class="title">Most Recent News</p>
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