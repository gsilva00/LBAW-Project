<div class="notification-card">
    <div class="profile-info appeal-wrapper">
    <p><?php echo e($unbanAppeal->description); ?></p>
    <form method="POST" action="<?php echo e(route('acceptUnbanAppeal', ['id' => $unbanAppeal->id])); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit" class="large-rectangle small-text greener">Unban</button>
    </form>
    <form method="POST" action="<?php echo e(route('rejectUnbanAppeal', ['id' => $unbanAppeal->id])); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit" class="large-rectangle small-text red-button">Reject</button>
    </form>
    </div>
</div><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/unban_appeal_tile.blade.php ENDPATH**/ ?>