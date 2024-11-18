

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.homepage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/homepage.blade.php ENDPATH**/ ?>