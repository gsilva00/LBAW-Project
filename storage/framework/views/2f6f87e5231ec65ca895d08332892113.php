<section id="recent-news-section">
    <p class="title">Most Recent News</p>
    <?php if($recentNews->isNotEmpty()): ?>
        <div class="<?php echo e($isHomepage ? 'homepage-style' : ''); ?>">
            <?php $__currentLoopData = $recentNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('partials.news_tile', ['article' => $article], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <p>No recent news available.</p>
    <?php endif; ?>
</section><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/recent_news.blade.php ENDPATH**/ ?>