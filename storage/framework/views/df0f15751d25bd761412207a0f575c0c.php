<?php
if (!($notifications instanceof \Illuminate\Support\Collection)) {
        $notifications = collect($notifications);
    }
?>

<?php if($notifications->isEmpty()): ?>
    <div class="not-available-container">                    
        <p>No notifications available.</p>
    </div>
<?php else: ?>
    <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('partials.notification_card', ['comment' => $notification], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/notification_list.blade.php ENDPATH**/ ?>