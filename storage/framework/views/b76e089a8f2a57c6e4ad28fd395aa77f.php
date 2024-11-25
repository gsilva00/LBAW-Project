<div>
    <p class="title">Trending Tags</p>
    <nav id="trending-tags-section">
        <?php $__currentLoopData = $trendingTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <p class="smaller-text"><?php echo e($loop->iteration); ?> Trending</p>
            <span><strong><a href="<?php echo e(route('search.show', ['tags' => [$tag->name]])); ?>"><?php echo e($tag->name); ?></a></strong></span><?php if(!$loop->last): ?><?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>
</div><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/trending_tags.blade.php ENDPATH**/ ?>