

<?php $__env->startSection('content'); ?>
<div class="homepage-wrapper">
    <?php if($articleItems->isNotEmpty()): ?>
        <div class="first-article">
        <?php
            $firstArticle = $articleItems->first();
        ?>
        <?php echo $__env->make('partials.first_tile', [
            'article' => $firstArticle], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="sec-articles">
        <?php $__currentLoopData = $articleItems->slice(1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('partials.news_tile', [
                'article' => $article,
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>
        <p>No articles available.</p>
    <?php endif; ?>
    <section class="news-tab-section">
        <?php echo $__env->make('partials.trending_tags',['trendingTags' => $trendingTags], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('partials.recent_news',['recentNews' => $recentNews], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.homepage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/homepage.blade.php ENDPATH**/ ?>