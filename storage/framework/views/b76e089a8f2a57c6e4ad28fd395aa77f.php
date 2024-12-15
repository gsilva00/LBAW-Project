<section>
    <a href="<?php echo e(route('showTrendingTags')); ?>"><h2 class="title">Trending Tags</h2></a>
    <nav id="trending-tags-section">
        <?php $__currentLoopData = $trendingTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <p class="smaller-text"><?php echo e($loop->iteration); ?> Trending</p>
            <span><strong><a href="<?php echo e(route('showTag', ['name' => $tag->name])); ?>"><?php echo e($tag->name); ?></a></strong></span>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>
</section><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/trending_tags.blade.php ENDPATH**/ ?>