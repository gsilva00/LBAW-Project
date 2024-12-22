<div class="notification-card">
    <div>
        <p>
            <a href="{{ route('showTag', ['name' => $tag->name]) }}">{{ $tag->name }}</a>
        </p>
    </div>
    <form method="POST" action="{{ route('toggleTrendingTag', ['id' => $tag->id]) }}" class="toggle-trending-form">
        @csrf
        <button type="submit" class="large-rectangle small-text trending-tag-action yellow-button" data-id="{{ $tag->id }}" data-is-trending="{{ $tag->is_trending }}">
            {{ $tag->is_trending ? 'Remove from Trending' : 'Add to Trending' }}
        </button>
    </form>
</div>