

<?php $__env->startSection('content'); ?>
<div class="recent-news-wrapper">
        <h1 class="large-rectangle">Followed tags</h1>
        <div class="profile-info border-bottom">
            <?php if(count($followedtags) == 0): ?>
                <h2>You are not following any tags yet.</h2>
            <?php else: ?>
                <?php $__currentLoopData = $followedtags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="tag">
                        <a href="<?php echo e(route('tag.show', ['name' => $tag->name])); ?>">
                            <h2>#<?php echo e($tag->name); ?></h2>
                        </a>
                        <p><?php echo e($tag->description); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
        <br>
        <section class="recent-news-container">
        <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('partials.long_news_tile', [
                'article' => $article,
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </section>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.homepage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/followedtags.blade.php ENDPATH**/ ?>