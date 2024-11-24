<div>
    <p class="title">Trending Tags</p>
    <nav id="trending-tags-section">
        @foreach($trendingTags as $tag)
            <p class="smaller-text">{{ $loop->iteration }} Trending</p>
            <span><strong><a href="{{ route('search.show', ['tags' => [$tag->name]]) }}">{{ $tag->name }}</a></strong></span>@if(!$loop->last)@endif
        @endforeach
    </nav>
</div>