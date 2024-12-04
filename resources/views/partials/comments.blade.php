@if($comments->isEmpty())
    <div class="not-available-container">
        <p>No comments available.</p>
    </div>
@else
    @foreach($comments as $comment)
        @include('partials.comment', ['comment' => $comment, 'replies' => $comment->replies, 'user' => $user, 'isReply' => false])
        @if($comment->replies->isNotEmpty())
            <button class="small-rectangle see-replies-button" title="See replies">
                <i class='bx bx-chevron-down remove-position' ></i>
                <span>{{ $comment->replies->count() }} {{ $comment->replies->count() > 1 ? 'Answers' : 'Answer' }}</span>
            </button>
            <div class="reply">
                @foreach($comment->replies as $reply)
                    @include('partials.comment', ['comment' => $reply, 'article' => $article, 'user' => $user, 'isReply' => true])
                @endforeach
            </div>
        @endif
    @endforeach
@endif
