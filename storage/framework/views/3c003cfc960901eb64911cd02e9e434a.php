

<?php $__env->startSection('content'); ?>
<div class="recent-news-wrapper">
    <h1 class="large-rectangle">Trending Tags</h1>
    <nav id="trending-tags-section">
        <?php $__currentLoopData = $trendingTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <p class="smaller-text"><?php echo e($loop->iteration); ?> Trending</p>
            <span><strong><a href="<?php echo e(route('tag.show', ['name' => $tag->name])); ?>"><?php echo e($tag->name); ?></a></strong> (<?php echo e($tag->articles_count); ?> articles)</span>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.homepage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/trending_tags_news.blade.php ENDPATH**/ ?>