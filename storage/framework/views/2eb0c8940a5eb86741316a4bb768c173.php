

<?php $__env->startSection('content'); ?>
    <div class="recent-news-wrapper">
        <h1 class="large-rectangle">Admin Panel</h1>
        <h2 class="large-rectangle">Create New User</h2>
        <form class="large-rectangle" method="POST" action="<?php echo e(route('profile.update')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <br>
            <div class="profile-info">
                <label for="username"><span>Username</span></label>
                <input type="text" name="username" id="username" value="<?php echo e(old('username')); ?>" placeholder="Enter username" autocomplete="off" required>
            </div>
            <?php if($errors->has('username')): ?>
                <br>
                <div class="profile-info">
                    <span class="error">
                        <?php echo e($errors->first('username')); ?>

                    </span>
                </div>
            <?php endif; ?>
            <br>
            <div class="profile-info">
                <label for="email"><span>Email</span></label>
                <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" placeholder="Enter email" autocomplete="email" required>
            </div>
            <?php if($errors->has('email')): ?>
                <br>
                <div class="profile-info">
                    <span class="error">
                    <?php echo e($errors->first('email')); ?>

                    </span>
                </div>
            <?php endif; ?>
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
            <p class="small-text">* Upload an image to change the current profile picture</p>
            <div class="profile-info">
                <label for="profile_picture"><span>Upload Profile Picture</span></label>
                <input type="file" name="profile_picture" id="profile_picture">
            </div>
            <?php if($errors->has('profile_picture')): ?>
                <br>
                <div class="profile-info">
                    <span class="error">
                        <?php echo e($errors->first('profile_picture')); ?>

                    </span>
                </div>
            <?php endif; ?>
            <br>
            <div class="profile-info">
                <label for="reputation"><span>Reputation (0-5)</span></label>
                <input type="number" name="reputation" id="reputation" value="<?php echo e(old('reputation', 3)); ?>" min="0" max="5">
            </div>
            <?php if($errors->has('reputation')): ?>
                <br>
                <div class="profile-info">
                <span class="error">
                    <?php echo e($errors->first('reputation')); ?>

                </span>
                </div>
            <?php endif; ?>
            <br>
            <div class="profile-info">
                <input type="checkbox" name="upvote_notification" id="upvote_notification" <?php echo e(old('upvote_notification', true) ? 'checked' : ''); ?>>
                <label for="upvote_notification"><span>Receive Upvote Notifications</span></label>
            </div>
            <br>
            <div class="profile-info">
                    <input type="checkbox" name="comment_notification" id="comment_notification" <?php echo e(old('comment_notification', true) ? 'checked' : ''); ?>>
                    <label for="comment_notification"><span>Receive Comment Notifications</span></label>
            </div>
            <br>
            <div class="profile-info">
                    <input type="checkbox" name="is_admin" id="is_admin" <?php echo e(old('is_admin') ? 'checked' : ''); ?>>
                    <label for="is_admin"><span>Is Admin</span></label>
            </div>
            <br>
            <div class="profile-info">
                    <input type="checkbox" name="is_fact_checker" id="is_fact_checker" <?php echo e(old('is_fact_checker') ? 'checked' : ''); ?>>
                    <label for="is_fact_checker"><span>Is Fact Checker</span></label>
            </div>
            <br>
            <br>
            <br>
            <div class="profile-info">
                <button type="submit" class="large-rectangle small-text greyer">Create</button> <!-- TODO HIGHLIGHT IN RED IF PASSWORD NOT INPUTTED (HARD TO SEE OTHERWISE) -->
            </div>
        </form>
        <br>
        <h2 class="large-rectangle">Users:</h2>
        <div id="users-section"> <!-- Make the height 2 or 3 users, or more if the user cards are made shorter -->
            <div id="user-list">
                <?php echo $__env->make('partials.user_tile_list', ['users' => $users], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <?php if($hasMorePages): ?>
                <button id="see-more-users" data-page-num="<?php echo e($currPageNum+1); ?>" data-url="<?php echo e(route('more.users')); ?>">Load More</button>
            <?php endif; ?>
        </div>
        <div id="another-section">
            <!-- <h2>Another Section to prove the scroll is working</h2> -->
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.homepage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/admin_panel.blade.php ENDPATH**/ ?>