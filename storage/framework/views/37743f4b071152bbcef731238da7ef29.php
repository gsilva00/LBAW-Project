<div class="notification-card">
    <div class="profile-info appeal-wrapper">
    <p><?php echo e($tagProposal->name); ?></p>
    <form class="accept-proposal-form" method="POST" action="<?php echo e(route('acceptTagProposal', ['id' => $tagProposal->id])); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit" class="large-rectangle small-text greener">Accept</button>
    </form>
    <form class="reject-proposal-form" method="POST" action="<?php echo e(route('rejectTagProposal', ['id' => $tagProposal->id])); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit" class="large-rectangle small-text red-button">Reject</button>
    </form>
    </div>
</div><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/propose_tag_tile.blade.php ENDPATH**/ ?>