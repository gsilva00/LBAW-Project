<?php if($commentsItems->isEmpty()): ?>
    <br>
    <div class="not-available-container">
    <p>No Comments/Replies found.</p>
    </div>
<?php else: ?>
    <?php $__currentLoopData = $commentsItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('partials.comment_searched', ['comment' => $comment, 'user' => $user, 'isReply' => $isReplies], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/comment_list_searched.blade.php ENDPATH**/ ?>