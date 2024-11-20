

<?php $__env->startSection('content'); ?>
    <div class="article-more-news-wrapper">
    <section class="article-section">
    <div class="large-rectangle">
        <a href="<?php echo e($previousUrl); ?>"><?php echo e($previousPage); ?></a> >
        <span><?php echo e($topic->name); ?></span> >
        <span><?php echo e($article->title); ?></span>
    </div>
    <div class="news-article">
        <h1 class="article-title border-bottom" ><?php echo e($article->title); ?></h1>
        <div class="article-credits">
            <p class="small-text">By <?php echo e($authorDisplayName); ?></p>
            <p class="small-text">OCTOBER 27th of 2025</p>
            <button class="small-text">Report News</button>
        </div>
        <p class="article-subtitle">A marca iconica da balacha oreo esta de volta so que com mais cacau</p>
        <p class="small-text">By Getty Images</p>
        <p class="article-text border-bottom"><?php echo e($article->content); ?></p>
        <div class="large-rectangle tags">
            <span>Topic:</span>
            <span><strong> <?php echo e($topic->name); ?></strong></span>
            <span>Tags:</span>
            <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span><strong><?php echo e($tag->name); ?></strong></span><?php if(!$loop->last): ?><?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    </section>
    <section class="more-news-section">
        <p>More News</p>
    </section>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.homepage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/articlePage.blade.php ENDPATH**/ ?>