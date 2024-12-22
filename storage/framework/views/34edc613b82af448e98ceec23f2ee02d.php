<form id="createTopicForm" class="large-rectangle yellow" method="POST" action="<?php echo e(route('adminCreateTopic')); ?>">
    <br>
    <?php echo csrf_field(); ?>
    <div class="profile-info">
        <label for="topic_name"><span>Topic Name</span></label>
        <input
            type="text"
            name="name"
            id="topic_name"
            placeholder="Enter topic name"
            required
            maxlength="30"
        >
    </div>
    <br>
    <div class="profile-info">
        <button type="submit" class="large-rectangle small-text greener">Create Topic</button>
    </div>
    <br>
</form><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/create_topic_form.blade.php ENDPATH**/ ?>