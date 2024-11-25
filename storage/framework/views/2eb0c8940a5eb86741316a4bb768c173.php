

<?php $__env->startSection('content'); ?>
    <div class="content">
        <div id="users-section" style="height: 800px; overflow-y: scroll;"> <!-- Make the height 2 or 3 users, or more if the user cards are made shorter -->
            <h2>Users:</h2>
            <a href="#" class="btn btn-primary">Add User</a> <!-- Takes too add user page -->
            <br>
            <ul id="user-list">
                <?php echo $__env->make('partials.user_tile_list', ['users' => $users], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </ul>
            <?php if($hasMorePages): ?>
                <button id="see-more-users" data-page-num="<?php echo e($currPageNum+1); ?>" data-url="<?php echo e(route('more.users')); ?>">Load More</button>
            <?php endif; ?>
        </div>
        <div id="another-section">
            <h2>Another Section to prove the scroll is working</h2>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.homepage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/admin_panel.blade.php ENDPATH**/ ?>