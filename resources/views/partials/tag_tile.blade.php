<div class="tag-container-admin">
    <div class="tag-info">
        <h2>
            <a href="{{ route('showTag', ['name' => $tag->name]) }}">{{ $tag->name }}</a>
        </h2>

    </div>
    <div class="tag-actions">
        <form method="POST" action="{{ route('toggleTrendingTag', ['id' => $tag->id]) }}" class="toggle-trending-form">
            @csrf
            <button type="submit" class="large-rectangle small-text greyer trending-tag-action" data-id="{{ $tag->id }}" data-is-trending="{{ $tag->is_trending }}">
                {{ $tag->is_trending ? 'Remove from Trending' : 'Add to Trending' }}
            </button>
        </form>
    </div>
</div>