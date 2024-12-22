<div class="notification-card">
    <div>
        <p>
            <a href="<?php echo e(route('showTag', ['name' => $tag->name])); ?>"><?php echo e($tag->name); ?></a>
        </p>
    </div>
    <form method="POST" action="<?php echo e(route('toggleTrendingTag', ['id' => $tag->id])); ?>" class="toggle-trending-form">
        <?php echo csrf_field(); ?>
        <button type="submit" class="large-rectangle small-text trending-tag-action yellow-button" data-id="<?php echo e($tag->id); ?>" data-is-trending="<?php echo e($tag->is_trending); ?>">
            <?php echo e($tag->is_trending ? 'Remove from Trending' : 'Add to Trending'); ?>

        </button>
    </form>
</div><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/tag_tile.blade.php ENDPATH**/ ?>