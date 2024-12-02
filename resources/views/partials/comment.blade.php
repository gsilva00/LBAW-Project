<div class="comment">
    <img src="{{ $comment->is_deleted ? asset('images/profile/default.jpg') : asset('images/profile/' . $comment->author->profile_picture) }}" alt="profile_picture">
    <div class="profile-info name-date">
    <p><strong>
        @if($article->is_deleted)
            Anonymous
        @else
            {{ $comment->author->display_name }}
        @endif
    </strong></p>
    <p class="small-text">{{ $comment->cmt_date ?? $comment->rpl_date }}</p>
    <p class="small-text">{{ $comment->is_edited ? '(edited)' : '' }}</p>
    @if(Auth::check() && $comment->author->display_name == $user->display_name  && !$comment->is_deleted)
        <button class="small-rectangle" title="reply comment"><i class='bx bx-pencil remove-position' ></i><span>Edit comment</span></button>
        <button class="small-rectangle" title="reply comment"><i class='bx bx-trash remove-position'></i><span>Delete comment</span></button>
    @endif
    </div>
    <span>{{ $article->is_deleted ? '[Deleted]' : $comment->content }}
    </span>
    <div class="comment-actions">
    <div class="large-rectangle fit-block comment-votes"><button><i class='bx bx-upvote' title="upvote comment"></i></button><span>{{ $comment->upvotes - $comment->downvotes}}</span><button title="upvote comment"><i class='bx bx-downvote' ></i></button></div>
    <button class="small-rectangle" title="reply comment"><i class='bx bx-message remove-position'></i><span>Reply</span></button>
    <button class="small-rectangle" title="report comment"><i class='bx bx-flag remove-position' ></i><span>Report</span></button>
    </div>
</div>