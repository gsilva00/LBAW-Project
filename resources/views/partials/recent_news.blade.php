<section id="recent-news-section">
<p class="title">Most Recent News</p>
@if($recentNews->isNotEmpty())
                @foreach($recentNews as $article)
                <div class="news-tile">
                    <a href="{{ route('article.show', ['id' => $article->id]) }}">
                        <img src="https://picsum.photos/seed/picsum/200/300" alt="News Image" style="width: 100%; height: auto;">
                        <p class="title">{{ $article->title }}</p>
                    </a>
                </div>
                @endforeach
        @else
            <p>No recent news available.</p>
        @endif
</section>