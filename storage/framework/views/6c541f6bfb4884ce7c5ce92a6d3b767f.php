<?php if($comments->isEmpty()): ?>
    <div class="not-available-container">
        <p>No comments available.</p>
    </div>
<?php else: ?>
    <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('partials.comment', ['comment' => $comment, 'replies' => $comment->replies, 'user' => $user, 'isReply' => false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php if($comment->replies->isNotEmpty()): ?>
            <button class="small-rectangle see-replies-button" title="See replies">
                <i class='bx bx-chevron-down remove-position' ></i>
                <span data-reply-count="<?php echo e($comment->id); ?>"><?php echo e($comment->replies->count()); ?> <?php echo e($comment->replies->count() > 1 ? 'Answers' : 'Answer'); ?></span>            </button>
            <div class="reply" data-reply-container data-comment-id="comment-<?php echo e($comment->id); ?>">
                <?php $__currentLoopData = $comment->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('partials.comment', ['comment' => $reply, 'user' => $user, 'isReply' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/comments.blade.php ENDPATH**/ ?>