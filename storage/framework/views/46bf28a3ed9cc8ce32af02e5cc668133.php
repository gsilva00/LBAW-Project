

<?php $__env->startSection('content'); ?>
    <div class="login-register-container">
        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>
            <br>
            <h1>Login</h1>
            <div class="profile-info space-between">
                <label for="login"><span>Email/Username</span></label>
                <input id="login" type="text" name="login" value="<?php echo e(old('login')); ?>" required autofocus autocomplete="username" placeholder="email/username">
            </div>
            <br>
            <div class="profile-info space-between">
                <label for="password"><span>Password</span></label>
                <input id="password" type="password" name="password" required>
            </div>
            <div class="Recover Password">
                <br>
                <a href="<?php echo e(route('recoverPasswordForm')); ?>" class="small-text">Forgot Your Password?</a>
            </div>
            <br>
            <div class="profile-info">
                <input type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                <label for="remember"><span>Remember Me</span></label>
            </div>
            <br>
            <button type="submit" class="large-rectangle small-text">
                Login
            </button>
            <br>
            <br>
        </form>
    </div>
    <div class="login-register-container">
        <div class="profile-info">
            <p>Don't have an account yet?</p>
            <a class="large-rectangle small-text" href="<?php echo e(route('register')); ?>">Register</a>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/auth/login.blade.php ENDPATH**/ ?>