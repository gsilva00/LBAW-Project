

<?php $__env->startSection('content'); ?>
    <div class="login-register-container">
        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo e(csrf_field()); ?>

            <h1>Login</h1>
            <div class="profile-info space-between">
                <label for="login"><span>Email/Username</span></label>
                <input id="login" type="text" name="login" value="<?php echo e(old('login')); ?>" required autofocus autocomplete="username" placeholder="email/username">
            </div>
            <?php if($errors->has('login')): ?>
                <?php echo $__env->make('partials.error_popup', ['field' => 'login'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <br>
            <div class="profile-info space-between">
                <label for="password"><span>Password</span></label>
                <input id="password" type="password" name="password" required>
                <?php if($errors->has('password')): ?>
                    <?php echo $__env->make('partials.error_popup', ['field' => 'password'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            </div>
            <?php if($errors->has('password')): ?>
                <?php echo $__env->make('partials.error_popup', ['field' => 'password'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <br>
            <div class="profile-info">
                <input type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                <label for="remember"><span>Remember Me</span></label>
            </div>
            <br>
            <div class="profile-info">
                <button type="submit" class="large-rectangle small-text">
                    Login
                </button>
                <a class="large-rectangle small-text" href="<?php echo e(route('register')); ?>">Register</a>
            </div>
            <br>
            <div class="Recover Password">
                <a href="<?php echo e(route('recoverPasswordForm')); ?>">Forgot Your Password?</a>
            </div>
            <?php echo $__env->make('partials.success_message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php if(session('error')): ?>
                <?php echo $__env->make('partials.error_popup', ['field' => 'error'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/auth/login.blade.php ENDPATH**/ ?>