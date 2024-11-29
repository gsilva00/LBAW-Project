<div class="profile-container-admin">
    <img src="<?php echo e(asset('images/profile/' . $user->profile_picture)); ?>" alt="profile_picture" class="user-profile-picture-admin">
    <div class="profile-info">
        <h2><?php echo e($user->display_name); ?></h2>
        <?php if($isAdmin): ?>
        <a href="<?php echo e(route('editProfile', ['username' => $user->username])); ?>">
            <button class="large-rectangle small-text greyer">Edit Profile</button>
        </a>
        <form action="<?php echo e(route('deleteProfile', ['id' => $user->id])); ?>" method="POST" style="display:inline;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="large-rectangle small-text greyer">Delete This Account</button>
        </form>
        <?php endif; ?>
        <?php if(Auth::check()): ?>
        <form  method="POST" style="display:inline;">
            <?php echo csrf_field(); ?>
            <?php if(Auth::user()->isFollowing($user)): ?>
                <button type="submit" class="large-rectangle small-text greyer">Unfollow User</button>
            <?php else: ?>
                <button type="submit" class="large-rectangle small-text greyer">Follow User</button>
            <?php endif; ?>
        </form>
        <?php endif; ?>
    </div>
</div><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/user_tile.blade.php ENDPATH**/ ?>