

<?php $__env->startSection('content'); ?>
<div class="recent-news-wrapper">
    <h1 class="large-rectangle">Favourite Articles</h1>
    <?php if($favArticles->isEmpty()): ?>
        <div class="not-available-container">
            <p>You have no favourite articles yet.</p>
        </div>
    <?php else: ?>
        <div class="recent-news-container">
            <?php $__currentLoopData = $favArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('partials.long_news_tile', [
                        'article' => $article,
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/favourite_articles.blade.php ENDPATH**/ ?>