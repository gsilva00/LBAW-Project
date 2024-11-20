

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>User Profile</h1>
        <p>Name: <?php echo e($profileUsername); ?></p>
        <p>Display Name: <?php echo e($displayName); ?></p>
        <?php if($isOwner): ?>
            <a href="<?php echo e(route('profile', ['username' => $username])); ?>"><button>Edit</button></a>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.homepage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/profile.blade.php ENDPATH**/ ?>