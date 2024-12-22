<form class="large-rectangle yellow" id="createFullUserForm" method="POST" action="<?php echo e(route('adminCreateUser')); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <br>
    <div class="profile-info">
        <label for="username"><span>Username</span></label>
        <input type="text" name="username" id="username" value="<?php echo e(old('username')); ?>" placeholder="Enter username" autocomplete="off" required>
    </div>
    <br>
    <div class="profile-info">
        <label for="email"><span>Email</span></label>
        <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" placeholder="Enter email" autocomplete="email" required>
    </div>
    <br>
    <div class="profile-info">
        <label for="display_name"><span>Display Name</span></label>
        <input type="text" name="display_name" id="display_name" value="<?php echo e(old('display_name')); ?>" placeholder="Enter display name" autocomplete="name">
    </div>
    <br>
    <div class="profile-info">
        <label for="description"><span>Description</span></label>
        <textarea name="description" id="description" placeholder="Enter description"><?php echo e(old('description')); ?></textarea>
    </div>
    <br>
    <div class="profile-info">
        <label for="password"><span>Password</span></label>
        <input type="password" name="password" id="password" placeholder="Enter password" autocomplete="new-password" required>
    </div>
    <br>
    <p class="small-text">* Upload an image for the user's profile picture</p>
    <div class="profile-info">
        <label for="profile_picture"><span>Upload Profile Picture</span></label>
        <input type="file" name="file" id="profile_picture">
    </div>
    <br>
    <div class="profile-info">
        <label for="reputation"><span>Reputation (0-5)</span></label>
        <input type="number" name="reputation" id="reputation" value="<?php echo e(old('reputation', 3)); ?>" min="0" max="5">
    </div>
    <br>
    <div class="profile-info">
        <input type="checkbox" name="upvote_notification" id="upvote_notification" value="1" <?php echo e(old('upvote_notification', true) ? 'checked' : ''); ?>>
        <label for="upvote_notification"><span>Receive Upvote Notifications</span></label>
    </div>
    <br>
    <div class="profile-info">
        <input type="checkbox" name="comment_notification" id="comment_notification" value="1" <?php echo e(old('comment_notification', true) ? 'checked' : ''); ?>>
        <label for="comment_notification"><span>Receive Comment Notifications</span></label>
    </div>
    <br>
    <div class="profile-info">
        <input type="checkbox" name="is_admin" id="is_admin" value="1" <?php echo e(old('is_admin') ? 'checked' : ''); ?>>
        <label for="is_admin"><span>Is Admin</span></label>
    </div>
    <br>
    <div class="profile-info">
        <input type="checkbox" name="is_fact_checker" id="is_fact_checker" value="1" <?php echo e(old('is_fact_checker') ? 'checked' : ''); ?>>
        <label for="is_fact_checker"><span>Is Fact Checker</span></label>
    </div>
    <br>
    <br>
    <br>
    <div class="profile-info">
        <button type="submit" class="large-rectangle small-text greener">Create User</button>
    </div>
    <br>
</form><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/create_user_form.blade.php ENDPATH**/ ?>