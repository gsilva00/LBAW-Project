<form id="comment-form" class="comment" method="POST" action="<?php echo e(route('writeComment', ['id' => $article->id])); ?>">
    <?php echo csrf_field(); ?>
    <?php if(Auth::guest() || $user->is_deleted): ?>
        <img src="<?php echo e(asset('images/profile/default.jpg')); ?>" alt="profile_picture">
    <?php else: ?>
        <img src="<?php echo e(asset('images/profile/' . $user->profile_picture)); ?>" alt="profile_picture">
    <?php endif; ?>
    <div class="comment-input-container">
        <?php if($state == "editComment"): ?>
            <input type="text" class="comment-input" name="comment" value="<?php echo e($comment->content); ?>" <?php if(Auth::guest() || $user->is_deleted): ?> disabled <?php endif; ?>>
        <?php else: ?>
            <input type="text" class="comment-input" name="comment" placeholder="Write a comment..." <?php if(Auth::guest() || $user->is_deleted): ?> disabled <?php endif; ?>>
        <?php endif; ?>

        <button class="small-rectangle" title="Send comment" <?php if(Auth::guest() || $user->is_deleted): ?> disabled <?php endif; ?>><i class='bx bx-send remove-position'></i><span>Send</span></button>
    </div>
</form><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/comment_write_form.blade.php ENDPATH**/ ?>