

<?php $__env->startSection('title', 'Search'); ?>

<?php $__env->startSection('content'); ?>
    <div class="recent-news-wrapper">
        <h1 class="large-rectangle">Comment Search Results</h1>
        <div class="large-rectangle">
            <p class="small-text">You searched for: <?php echo e($searchQuery); ?></p>
        </div>
        <br>
        <div class="search-comments-options-container" data-toggle="buttons">
            <label class="active" tabindex="0">
                <input type="radio" name="search-comment-options" id="comments-tab" checked aria-controls="comments-searched"> <i class='bx bx-chat'></i>Comments
            </label>
            <label tabindex="0">
                <input type="radio" name="search-comment-options" id="replies-tab" aria-controls="replies-searched"> <i class='bx bx-conversation'></i>Replies
            </label>
        </div>

        <div class="comments-grid" id="comments-searched">
            <?php echo $__env->make('partials.comment_list_searched', ['commentsItems' => $commentsItems, 'user' => $user, 'isReplies' => false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="replies-grid" id="replies-searched" style="display: none;">
            <?php echo $__env->make('partials.comment_list_searched', ['commentsItems' => $repliesItems, 'user' => $user, 'isReplies' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/search_comments.blade.php ENDPATH**/ ?>