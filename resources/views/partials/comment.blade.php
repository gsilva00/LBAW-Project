<div class="comment" data-is-reply="{{ $isReply ? 'true' : 'false' }}" id="{{ $isReply ? 'reply-' . $comment->id : 'comment-' . $comment->id }}">
    <img src="{{ $comment->is_deleted ? asset('images/profile/default.jpg') : asset('images/profile/' . $comment->author->profile_picture) }}" alt="Profile picture">
    <div class="profile-info name-date">
        <p><strong>
                @if($comment->is_deleted || $comment->author->is_deleted)
                    Anonymous
                @else
                    <a href="{{ route('profile', ['username' => $comment->author->username]) }}">
                        {{ $comment->author->display_name }}
                    </a>
                @endif
            </strong></p>
        <p class="small-text">{{ $comment->cmt_date ?? $comment->rpl_date }}</p>
        <p class="small-text">{{ $comment->is_edited ? '(edited)' : '' }}</p>
        @if(Auth::check() && $comment->author->display_name == $user->display_name  && !$comment->is_deleted)
            <button class="small-rectangle" title="reply comment">
                <i class='bx bx-pencil remove-position' ></i>
                <span>Edit comment</span>
            </button>
            <button id="delete-comment-button" class="small-rectangle" title="reply comment">
                <i class='bx bx-trash remove-position'></i>
                <span>Delete comment</span>
            </button>
        @endif
    </div>
    <span>{{ $comment->is_deleted ? '[Deleted]' : $comment->content }}
    </span>
    <div class="comment-actions">
        <div class="large-rectangle fit-block comment-votes">
            @php
                $user = Auth::user();
                $isUpvoted = $user ? $comment->isUpvotedBy($user) : false;
                $isDownvoted = $user ? $comment->isDownvotedBy($user) : false;
            @endphp
            @if(!$comment->is_deleted)
                <button class="upvote-comment-button" data-comment-id="{{ $comment->id }}">
                    <i class='bx {{ $isUpvoted ? "bxs-upvote" : "bx-upvote" }}' title="upvote comment"></i>
                </button>
                <span id="comment-{{ $comment->id }}" class="upvote-count">{{ $comment->upvotes - $comment->downvotes }}</span>
                <button class="downvote-comment-button" data-comment-id="{{ $comment->id }}" title="downvote comment">
                    <i class='bx {{ $isDownvoted ? "bxs-downvote" : "bx-downvote" }}' title="downvote comment"></i>
                </button>
            @endif
        </div>
        @if(!$comment->is_deleted && Auth::check())
            @if(!$isReply)
                <button class="small-rectangle" title="reply comment">
                    <i class='bx bx-message remove-position'></i>
                    <span>Reply</span>
                </button>
            @endif
            <button class="small-rectangle" title="report comment">
                <i class='bx bx-flag remove-position' ></i>
                <span>Report</span>
            </button>
        @endif

    </div>
</div>
