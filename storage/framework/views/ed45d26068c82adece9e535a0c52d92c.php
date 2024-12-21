<a href="<?php echo e(route('profile', ['username' => $user->username])); ?>">
    <div class="user-search-container">
        <img src="<?php echo e(asset('images/profile/' . $user->profile_picture)); ?>" class="user-profile-picture-admin" alt="Searched user's profile picture">
        <p> <?php echo e($user->display_name); ?> </p>
        <span class="small-text"><?php echo e($user->username); ?></span>
    </div>
</a><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/user_searched.blade.php ENDPATH**/ ?>