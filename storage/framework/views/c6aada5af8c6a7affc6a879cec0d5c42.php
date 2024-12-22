

<?php $__env->startSection('content'); ?>
    <div class="login-register-container">
        <form method="POST" action="<?php echo e(route('register')); ?>">
            <?php echo csrf_field(); ?>
            <br>
            <h1>Register</h1>
            <div class="profile-info space-between">
                <label for="username"><span>Username</span></label>
                <input id="username" type="text" name="username" value="<?php echo e(old('username')); ?>" required autofocus
                       autocomplete="off">
            </div>
            <br>
            <div class="profile-info space-between">
                <label for="email"><span>E-Mail</span></label>
                <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email">
            </div>
            <br>
            <div class="profile-info space-between">
                <label for="password"><span>Password</span></label>
                <input id="password" type="password" name="password" required>
            </div>
            <br>
            <div class="profile-info space-between">
                <label for="password-confirm"><span>Confirm Password</span></label>
                <input id="password-confirm" type="password" name="password_confirmation" required>
            </div>
            <br>
            <br>
                <button type="submit" class="large-rectangle small-text">
                    Register
                </button>
            <br>
            <br>
        </form>
    </div>
    <div class="login-register-container">
        <div class="profile-info">
            <p>Already have an account?</p>
            <a class="large-rectangle small-text" href="<?php echo e(route('login')); ?>">Login</a>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/auth/register.blade.php ENDPATH**/ ?>