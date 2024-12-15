

<?php $__env->startSection('title', 'User Feed'); ?>

<?php $__env->startSection('content'); ?>
    <br>
    <div class="recent-news-wrapper">
        <div class="feed-options-container" data-toggle="buttons">
            <label class="feed-option active" data-url="<?php echo e(route('showFollowingTags')); ?>">
                <input type="radio" name="feed-options" checked> <i class='bx bx-purchase-tag'></i>Followed Tags
            </label>
            <label class="feed-option" data-url="<?php echo e(route('showFollowingTopics')); ?>">
                <input type="radio" name="feed-options"><i class='bx bx-book'></i> Followed Topics
            </label>
            <label class="feed-option" data-url="<?php echo e(route('showFollowingAuthors')); ?>">
                <input type="radio" name="feed-options"><i class='bx bx-heart'></i> Followed Authors
            </label>
        </div>
        <br>
        <div id="articles">
            <div id="comment-form" class="recent-news-container">
                <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('partials.long_news_tile', [
                        'article' => $article,
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/user_feed.blade.php ENDPATH**/ ?>