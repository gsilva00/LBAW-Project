<div class="comment" data-is-reply="<?php echo e($isReply ? 'true' : 'false'); ?>" id="<?php echo e($isReply ? 'reply-' . $comment->id : 'comment-' . $comment->id); ?>">
    <img src="<?php echo e($comment->is_deleted ? asset('images/profile/default.jpg') : asset('images/profile/' . $comment->author->profile_picture)); ?>" alt="Comment's author profile picture">
    <div class="profile-info name-date">
        <p><strong>
                <?php if($comment->is_deleted || $comment->author->is_deleted): ?>
                    Anonymous
                <?php else: ?>
                    <a href="<?php echo e(route('profile', ['username' => $comment->author->username])); ?>">
                        <?php echo e($comment->author->display_name); ?>

                    </a>
                <?php endif; ?>
            </strong></p>
        <p class="small-text"><?php echo e($comment->cmt_date ?? $comment->rpl_date); ?></p>
        <p class="small-text"><?php echo e($comment->is_edited ? '(edited)' : ''); ?></p>
        <?php if(Auth::check() && $comment->author->display_name == $user->display_name  && !$comment->is_deleted): ?>
            <button class="small-rectangle" title="reply comment">
                <i class='bx bx-pencil remove-position' ></i>
                <span>Edit comment</span>
            </button>
            <button id="delete-comment-button" class="small-rectangle" title="reply comment">
                <i class='bx bx-trash remove-position'></i>
                <span>Delete comment</span>
            </button>
        <?php endif; ?>
    </div>
    <span><?php echo e($comment->is_deleted ? '[Deleted]' : $comment->content); ?>

    </span>
    <div class="comment-actions">
        <div class="large-rectangle fit-block comment-votes">
            <?php
                $user = Auth::user();
                $isUpvoted = $user ? $comment->isUpvotedBy($user) : false;
                $isDownvoted = $user ? $comment->isDownvotedBy($user) : false;
            ?>
            <?php if(!$comment->is_deleted): ?>
                <button class="upvote-comment-button" data-comment-id="<?php echo e($comment->id); ?>">
                    <i class='bx <?php echo e($isUpvoted ? "bxs-upvote" : "bx-upvote"); ?>' title="upvote comment"></i>
                </button>
                <span id="comment-<?php echo e($comment->id); ?>" class="upvote-count"><?php echo e($comment->upvotes - $comment->downvotes); ?></span>
                <button class="downvote-comment-button" data-comment-id="<?php echo e($comment->id); ?>" title="downvote comment">
                    <i class='bx <?php echo e($isDownvoted ? "bxs-downvote" : "bx-downvote"); ?>' title="downvote comment"></i>
                </button>
            <?php endif; ?>
        </div>
        <?php if(!$isReply): ?>
            <button class="small-rectangle" onclick="window.location.href='<?php echo e(route('showArticle', ['id' => $comment->article_id])); ?>'">
                <i class='bx bx-show remove-position' ></i>
                View Article
            </button>
        <?php else: ?>
            <button class="small-rectangle" onclick="window.location.href='<?php echo e(route('showArticle', ['id' => $comment->comment->article_id])); ?>'">
                <i class='bx bx-show remove-position' ></i>
                View Article
            </button>
        <?php endif; ?>

    </div>
</div>
<?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/comment_searched.blade.php ENDPATH**/ ?>