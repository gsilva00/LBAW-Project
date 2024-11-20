<section id="recent-news-section">
<p class="title">Most Recent News</p>
@if($recentNews->isNotEmpty())
                @foreach($recentNews as $news)
                <div class="news-tile">
                    <a href="{{ route('news.show', ['id' => $news->id]) }}">
                        <img src="https://picsum.photos/seed/picsum/200/300" alt="News Image" style="width: 100%; height: auto;">
                        <p class="title">{{ $news->title }}</p>
                    </a>
                </div>
                @endforeach
        @else
            <p>No recent news available.</p>
        @endif
</section>