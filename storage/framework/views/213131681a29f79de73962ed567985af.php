<?php if(!$user->is_deleted): ?>
    <div class="profile-container-admin" author-id="<?php echo e($user->id); ?>">
        <img src="<?php echo e(asset('images/profile/' . $user->profile_picture)); ?>" alt="profile_picture" class="user-profile-picture-admin">

        <div class="profile-info">
            <h2>
                <a href="<?php echo e(route('profile', ['username' => $user->username])); ?>">
                    <?php echo e($user->display_name); ?>

                </a>
            </h2>
            <?php if(!$isAdminPanel): ?>
                <div>
                    <?php echo csrf_field(); ?>
                    <?php if(Auth::user()->isFollowing($user)): ?>
                        <button type="button" class="unfollow-user-button-profile large-rectangle small-text greyer" data-user-id="<?php echo e(Auth::id()); ?>" data-profile-id="<?php echo e($user->id); ?>" data-url="<?php echo e(route('unfollowUserAction')); ?>">Unfollow User</button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if(Auth::user()->is_admin): ?>
                <a href="<?php echo e(route('editProfile', ['username' => $user->username])); ?>">
                    <button class="large-rectangle small-text greyer">Edit Profile</button>
                </a>
                <form action="<?php echo e(route('deleteProfile', ['id' => $user->id])); ?>" method="POST" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="large-rectangle small-text greyer">Delete This Account</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/user_tile.blade.php ENDPATH**/ ?>