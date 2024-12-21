

<?php $__env->startSection('title', 'Search'); ?>

<?php $__env->startSection('content'); ?>
    <div class="recent-news-wrapper">
        <h1 class="large-rectangle">Search Results</h1>
        <div class="large-rectangle">
            <p class="small-text">You searched for: <?php echo e($searchQuery); ?></p>
        </div>

        <?php if($usersItems->isEmpty()): ?>
            <p>No Users found.</p>
        <?php else: ?>
            <div class="news-grid">
                <?php $__currentLoopData = $usersItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('partials.user_searched', ['user' => $userItem], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/search_users.blade.php ENDPATH**/ ?>