

<?php $__env->startSection('title', 'Most Recent News'); ?>

<?php $__env->startSection('content'); ?>
    <div class="recent-news-wrapper">
        <h1 class="large-rectangle">Most Recent News</h1>
        <?php if($recentNews->isNotEmpty()): ?>
            <div class="recent-news-container">
                <?php $__currentLoopData = $recentNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('partials.long_news_tile', [
                        'article' => $article,
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p>No recent news available.</p>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/recent_news.blade.php ENDPATH**/ ?>