

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Edit User Profile</h1>
        <form method="POST" action="<?php echo e(route('profile.update')); ?>" >
            <?php echo csrf_field(); ?>
            <label for="username">Username</label>
            <input type="text" name="username" value="<?php echo e(old('username', $username)); ?>">
            <?php if($errors->has('username')): ?>
                <span class="error">
                    <?php echo e($errors->first('username')); ?>

                </span>
            <?php endif; ?>

            <br>

            <label for="email">Email</label>
            <input type="email" name="email" value="<?php echo e(old('email', $email)); ?>">
            <?php if($errors->has('email')): ?>
                <span class="error">
                    <?php echo e($errors->first('email')); ?>

                </span>
            <?php endif; ?>

            <br>

            <label for="display_name">Display Name</label>
            <input type="text" name="display_name" value="<?php echo e(old('display_name', $displayName)); ?>">

            <br>

            <label for="description">Description</label>
            <input type="text" name="description" value="<?php echo e(old('description', $description)); ?>">

            <br>

            <label for="cur_password">Current Password</label>
            <input type="password" name="cur_password">
            <?php if($errors->has('cur_password')): ?>
                <span class="error">
                    <?php echo e($errors->first('cur_password')); ?>

                </span>
            <?php endif; ?>

            <br>

            <label for="new_password">New Password</label>
            <input type="password" name="new_password">
            <?php if($errors->has('new_password')): ?>
                <span class="error">
                    <?php echo e($errors->first('new_password')); ?>

                </span>
            <?php endif; ?>

            <br>

            <label for="new_password_confirmation">Confirm Password</label>
            <input type="password" name="new_password_confirmation">
            <?php if($errors->has('new_password_confirmation')): ?>
                <span class="error">
                    <?php echo e($errors->first('new_password_confirmation')); ?>

                </span>
            <?php endif; ?>

            <br>

            <button type="submit">Save</button>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.homepage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/profileEdit.blade.php ENDPATH**/ ?>