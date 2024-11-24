

<?php $__env->startSection('content'); ?>
    <div class="profile-wrapper">
        <h1 class="large-rectangle">Edit User Profile</h1>
        <section class="profile-container">
            <form method="POST" action="<?php echo e(route('profile.update')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <br>
                <h2><strong>General Profile Information</strong></h2>
                <div class="profile-info">
                    <label for="username"><span>Username</span></label>
                    <input type="text" name="username" id="username" value="<?php echo e(old('username', $user->username)); ?>" autocomplete="off">
                    <?php if($errors->has('username')): ?>
                        <span class="error">
                            <?php echo e($errors->first('username')); ?>

                        </span>
                    <?php endif; ?>
                </div>
                <br>
                <div class="profile-info">
                    <label for="email"><span>Email</span></label>
                    <input type="email" name="email" id="email" value="<?php echo e(old('email', $user->email)); ?>" autocomplete="email">
                    <?php if($errors->has('email')): ?>
                        <span class="error">
                            <?php echo e($errors->first('email')); ?>

                        </span>
                    <?php endif; ?>
                </div>
                <br>
                <div class="profile-info">
                    <label for="display_name"><span>Display Name</span></label>
                    <input type="text" name="display_name" id="display_name" value="<?php echo e(old('display_name', $user->display_name)); ?>" autocomplete="name">
                </div>
                <br>
                <div class="profile-info">
                    <label for="description"><span>Description</span></label>
                    <input type="text" name="description" id="description" value="<?php echo e(old('description', $user->description)); ?>">
                </div>
                <br>
                <p class="small-text">* Upload an image to change the current profile picture</p>
                <div class="profile-info">
                    <label for="profile_picture"><span>Upload Profile Picture</span></label>
                    <input type="file" name="profile_picture" id="profile_picture">
                    <?php if($errors->has('profile_picture')): ?>
                        <span class="error">
                            <?php echo e($errors->first('profile_picture')); ?>

                        </span>
                    <?php endif; ?>
                </div>
                <br>
                <p class="small-text">* Write password to confirm any changes to profile</p>
                <div class="profile-info">
                    <label for="cur_password"><span>Current Password</span></label>
                    <input type="password" name="cur_password" id="cur_password" placeholder="password">
                    <?php if($errors->has('cur_password')): ?>
                        <span class="error">
                            <?php echo e($errors->first('cur_password')); ?>

                        </span>
                    <?php endif; ?>
                </div>
                <br>
                <h2><strong>Optional: Change Password</strong></h2>
                <div class="profile-info">
                    <label for="new_password"><span>New Password</span></label>
                    <input type="password" name="new_password" id="new_password" placeholder="new password">
                    <?php if($errors->has('new_password')): ?>
                        <span class="error">
                            <?php echo e($errors->first('new_password')); ?>

                        </span>
                    <?php endif; ?>
                </div>
                <br>
                <div class="profile-info">
                    <label for="new_password_confirmation"><span>Confirm Password</span></label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="new password">
                    <?php if($errors->has('new_password_confirmation')): ?>
                        <span class="error">
                            <?php echo e($errors->first('new_password_confirmation')); ?>

                        </span>
                    <?php endif; ?>
                </div>
                <br>
                <br>
                <br>
                <br>
                <div class="profile-info">
                    <span>Don't forget to save after alterations:</span>
                    <button type="submit" class="large-rectangle small-text greyer">Save</button> <!-- TODO HIGHLIGHT IN RED IF PASSWORD NOT INPUTTED (HARD TO SEE OTHERWISE) -->
                </div>
            </form>
            </section>
            <section class="profile-container">
            <form>
                <?php echo csrf_field(); ?>
                <br>
                <h2><strong>Delete account</strong></h2>
                <?php if($isOwner): ?>
                <p>Write password to erase your account and then press "Delete This Account"</p>
                <div class="profile-info">
                    <label for="cur_password_delete"><span>Current Password</span></label>
                    <input type="password" name="cur_password_delete" id="cur_password_delete" placeholder="password">
                    <?php if($errors->has('cur_password')): ?>
                        <span class="error">
                            <?php echo e($errors->first('cur_password')); ?>

                        </span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <br>
                <div class="profile-info">
                    <span>Do you want to erase this account?</span>
                    <button class="large-rectangle small-text greyer"> Delete This Account </button>  <!-- TODO action here -->
                </div>
                <br>
            </form>
        </section>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.homepage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/profile_edit.blade.php ENDPATH**/ ?>