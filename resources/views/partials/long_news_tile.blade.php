<a href="{{ route('article.show', ['id' => $article->id]) }}">
    <div class="long-article-container news-tile">
        <img src="https://picsum.photos/seed/picsum/1200/1300" alt="News Image">
        <div class="long-article-title-subtitle">
            <span class="article-title" >{{ $article->title }}</span>
            <div class="article-meta-container">
            <span class="small-text">By {{ $article->author->display_name ?? 'Unknown' }}</span>
            <span class="small-text">Created at: {{ $article->create_date }}</span>
                <span class="small-text">
                @if($article->is_edited)
                Edited at: {{ $article->edit_date }}
                @else

                @endif
            </span>
            </div>
            <span class="small-text">Total Votes: {{ $article->upvotes - $article->downvotes}}</span>
        </div>
        <div class="long-article-credits">
            <span>{{ $article->subtitle }}</span>
        </div>
    </div>
</a>