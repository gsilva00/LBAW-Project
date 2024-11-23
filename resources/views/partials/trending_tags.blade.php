<div>
    <p class="title">Trending Tags</p>
    <nav id="trending-tags-section">
        @foreach($trendingTags as $tag)
            <p class="smaller-text">{{ $loop->iteration }} Trending</p>
            <span>{{ $tag->name }}</span>
        @endforeach
    </nav>
</div>