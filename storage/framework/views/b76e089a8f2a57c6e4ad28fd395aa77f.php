<div>
<p class="title">Trending Tags</p>
<nav id="trending-tags-section">
    <?php $__currentLoopData = $trendingTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p class="smaller-text"><?php echo e($loop->iteration); ?> Trending</p>
        <span><?php echo e($tag->name); ?></span>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</nav>
</div><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/trending_tags.blade.php ENDPATH**/ ?>