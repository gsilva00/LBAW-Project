

<?php $__env->startSection('content'); ?>
<div class="recent-news-wrapper">
    <h1 class="large-rectangle">Saved Articles</h1>
    <?php if($savedArticles->isEmpty()): ?>
        <div class="not-available-container">
            <p>No saved articles available.</p>
        </div>
    <?php else: ?>
        <div class="articles-list">
            <?php $__currentLoopData = $savedArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('partials.long_news_tile', [
                        'article' => $article,
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/saved_articles.blade.php ENDPATH**/ ?>