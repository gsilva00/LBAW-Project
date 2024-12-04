<section>
    <a href="{{ route('showTrendingTags') }}"><h2 class="title">Trending Tags</h2></a>
    <nav id="trending-tags-section">
        @foreach($trendingTags as $tag)
            <p class="smaller-text">{{ $loop->iteration }} Trending</p>
            <span><strong><a href="{{ route('showTag', ['name' => $tag->name]) }}">{{ $tag->name }}</a></strong></span>
        @endforeach
    </nav>
</section>