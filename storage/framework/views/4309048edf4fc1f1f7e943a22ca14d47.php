<div class="comment">
    <p><strong><?php echo e($comment->author->display_name); ?>:</strong> <?php echo e($comment->content); ?></p>
    <p><strong>Date:</strong> <?php echo e($comment->cmt_date); ?></p>
    <p><strong>Upvotes:</strong> <?php echo e($comment->upvotes); ?> <strong>Downvotes:</strong> <?php echo e($comment->downvotes); ?></p>
    <p><strong>Edited:</strong> <?php echo e($comment->is_edited ? 'Yes' : 'No'); ?></p>
</div><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/comment.blade.php ENDPATH**/ ?>