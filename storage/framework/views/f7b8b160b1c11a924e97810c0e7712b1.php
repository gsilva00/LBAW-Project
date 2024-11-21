

<?php $__env->startSection('content'); ?>
    <h1>Search Results</h1>
    <p>You searched for: <?php echo e($searchQuery); ?></p>
    <?php if($articleItems->isEmpty()): ?>
        <p>No articles found.</p>
    <?php else: ?>
        <div class="news-grid">
            <?php $__currentLoopData = $articleItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('partials.news_tile', ['article' => $article], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.homepage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/search.blade.php ENDPATH**/ ?>