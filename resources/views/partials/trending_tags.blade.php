<div>
    <p class="title"><a href="{{ route('trendingtags') }}">Trending Tags</a></p>
    <nav id="trending-tags-section">
        @foreach($trendingTags as $tag)
            <p class="smaller-text">{{ $loop->iteration }} Trending</p>
            <span><strong><a href="{{ route('tag.show', ['name' => $tag->name]) }}">{{ $tag->name }}</a></strong></span>@if(!$loop->last)@endif
        @endforeach
    </nav>
</div>