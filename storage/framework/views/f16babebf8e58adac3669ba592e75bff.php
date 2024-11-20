

<?php $__env->startSection('content'); ?>
    <h1>Welcome <?php echo e($username ?? 'Guest'); ?></h1>
    <?php if(Auth::check()): ?>
        <form class="button" action="<?php echo e(route('logout')); ?>" method="GET">
            <?php echo csrf_field(); ?>
            <button type="submit">Logout</button>
        </form>
    <?php else: ?>
        <a class="button" href="<?php echo e(route('login')); ?>">
            <button type="button">Login</button>
        </a>
    <?php endif; ?>
    <div class="news-grid">
        <?php $__currentLoopData = $articleItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('partials.news_tile', ['article' => $article], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.homepage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/homepage.blade.php ENDPATH**/ ?>