

<?php $__env->startSection('title', 'Edit Profile'); ?>

<?php $__env->startSection('content'); ?>
    <div class="profile-wrapper">
        <h1 class="large-rectangle">Edit User Profile</h1>
        <section class="profile-container large-rectangle">
            <form method="POST" action="<?php echo e(route('updateProfile', ['username' => $profileUser->username])); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <br>
                <h2><strong>General Profile Information</strong></h2>
                <div class="profile-info">
                    <label for="username"><span>Username</span></label>
                    <input type="text" name="username" id="username" value="<?php echo e($profileUser->username); ?>" autocomplete="off" disabled>
                    <input type="hidden" name="username" value="<?php echo e($profileUser->username); ?>">
                    <!-- So that the username value is actually submitted (disabled inputs aren't submitted) -->
                </div>
                <?php if($errors->has('username')): ?>
                    <?php echo $__env->make('partials.error_popup', ['field' => 'username'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                <br>
                <div class="profile-info">
                    <label for="email"><span>Email</span></label>
                    <input type="email" name="email" id="email" value="<?php echo e(old('email', $profileUser->email)); ?>" autocomplete="email">
                </div>
                <?php if($errors->has('email')): ?>
                    <?php echo $__env->make('partials.error_popup', ['field' => 'email'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                <br>
                <div class="profile-info">
                    <label for="display_name"><span>Display Name</span></label>
                    <input type="text" name="display_name" id="display_name" value="<?php echo e(old('display_name', $profileUser->display_name)); ?>" autocomplete="name">
                </div>
                <br>
                <div class="profile-info">
                    <label for="description"><span>Description</span></label>
                    <input type="text" name="description" id="description" value="<?php echo e(old('description', $profileUser->description)); ?>">
                </div>
                <br>
                <p class="small-text">* Upload an image to change the current profile picture</p>
                <div class="profile-info">
                    <label for="profile_picture"><span>Upload Profile Picture</span></label>
                    <input type="file" name="profile_picture" id="profile_picture">
                </div>
                <?php if($errors->has('profile_picture')): ?>
                    <?php echo $__env->make('partials.error_popup', ['field' => 'profile_picture'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                <br>
                <?php if($user->is_admin && !$isOwner): ?>
                    <p class="small-text">* Admins don't need to confirm the password to make any changes to the profile</p>
                    <div class="profile-info">
                        <label for="cur_password"><span>Current Password</span></label>
                        <input type="password" name="cur_password" id="cur_password" value="********" disabled>
                    </div>
                <?php else: ?>
                    <p class="small-text">* Write password to confirm any changes to the profile</p>
                    <div class="profile-info">
                        <label for="cur_password"><span>Current Password</span></label>
                        <input type="password" name="cur_password" id="cur_password" placeholder="Password">
                    </div>
                    <?php if($errors->has('cur_password')): ?>
                        <?php echo $__env->make('partials.error_popup', ['field' => 'cur_password'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                <?php endif; ?>
                <br>
                <h2><strong>Optional: Change Password</strong></h2>
                <div class="profile-info">
                    <label for="new_password"><span>New Password</span></label>
                    <input type="password" name="new_password" id="new_password" placeholder="New Password">
                </div>
                <?php if($errors->has('new_password')): ?>
                    <?php echo $__env->make('partials.error_popup', ['field' => 'new_password'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                <br>
                <div class="profile-info">
                    <label for="new_password_confirmation"><span>Confirm Password</span></label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="New Password">
                </div>
                <?php if($errors->has('new_password_confirmation')): ?>
                    <?php echo $__env->make('partials.error_popup', ['field' => 'new_password_confirmation'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                <br>
                <br>
                <br>
                <br>
                <div class="profile-info">
                    <span>Don't forget to save after alterations:</span>
                    <button type="submit" class="large-rectangle small-text greyer">Save</button>
                </div>
            </form>
        </section>
        <section class="profile-container large-rectangle">
            <form action="<?php echo e(route('deleteProfile', ['id' => $profileUser->id])); ?>" method="POST" style="display:inline;">
            <?php echo csrf_field(); ?>
                <br>
                <h2><strong>Delete account</strong></h2>
                <?php if($isOwner): ?>
                    <p>Write password to erase your account and then press "Delete This Account"</p>
                    <div class="profile-info">
                        <label for="cur_password_delete"><span>Current Password</span></label>
                        <input type="password" name="cur_password_delete" id="cur_password_delete" placeholder="password">
                    </div>
                    <?php if($errors->has('cur_password_delete')): ?>
                        <?php echo $__env->make('partials.error_popup', ['field' => 'cur_password_delete'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                <?php endif; ?>
                <br>
                <div class="profile-info">
                    <span>Do you want to erase this account?</span>
                    <button type="submit" class="large-rectangle small-text greyer">Delete This Account</button>
                </div>
                <br>
            </form>
        </section>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/edit_profile.blade.php ENDPATH**/ ?>