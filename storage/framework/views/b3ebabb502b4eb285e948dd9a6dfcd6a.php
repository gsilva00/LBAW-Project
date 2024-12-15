

<?php $__env->startSection('title', $topic->name); ?>

<?php $__env->startSection('content'); ?>
    <div class="recent-news-wrapper">
        <div class="profile-info">
        <h1 class="large-rectangle"><?php echo e($topic->name); ?></h1>
        <?php if(Auth::check()): ?>
        <form method="POST" action="<?php echo e(Auth::user()->hasFollowedTopic($topic) ? route('unfollowTopic', $topic->name) : route('followTopic', $topic->name)); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="large-rectangle small-text greyer">
                <?php echo e(Auth::user()->hasFollowedTopic($topic) ? 'Unfollow topic' : 'Follow topic'); ?>

            </button>
        </form>
        <?php endif; ?>
        </div>
        <div class="recent-news-container">
            <?php $__currentLoopData = $topic->articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('partials.long_news_tile', [
                    'article' => $article,
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/topic_page.blade.php ENDPATH**/ ?>