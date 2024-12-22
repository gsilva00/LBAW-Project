<form id="createTagForm" class="large-rectangle yellow" method="POST" action="<?php echo e(route('createTag')); ?>">
    <?php echo csrf_field(); ?>
    <br>
    <div class="profile-info">
        <label for="tag_name"><span>Tag Name</span></label>
        <input
            type="text"
            name="name"
            id="tag_name"
            placeholder="Enter tag name"
            required
            maxlength="30"
        >
    </div>
    <br>
    <div class="profile-info">
        <input type="checkbox" name="is_trending" id="is_trending" value="1">
        <label for="is_trending"><span>Is the tag trending?</span></label>
    </div>
    <br>
    <div class="profile-info">
        <button type="submit" class="large-rectangle small-text greener">Create Tag</button>
    </div>
    <br>
</form><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/create_tag_form.blade.php ENDPATH**/ ?>