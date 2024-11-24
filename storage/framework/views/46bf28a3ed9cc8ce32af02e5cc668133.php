

<?php $__env->startSection('content'); ?>
<div class="profile-wrapper login-register-container">
    <form method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo e(csrf_field()); ?>

        <h1>Login</h1>
        <div class="profile-info space-between">
            <label for="email"><span>E-mail</span></label>
            <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="email">
            <?php if($errors->has('email')): ?>
                <span class="error">
                  <?php echo e($errors->first('email')); ?>

                </span>
            <?php endif; ?>
        </div>
        <br>
        <div class="profile-info space-between">
            <label for="password" ><span>Password</span></label>
            <input id="password" type="password" name="password" required>
            <?php if($errors->has('password')): ?>
                <span class="error">
                    <?php echo e($errors->first('password')); ?>

                </span>
            <?php endif; ?>
        </div>
        <br>
        <div class="profile-info">
            <input type="checkbox" name="remember" id="rebember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
            <label for="rebember"><span>Remember Me</span></label>
        </div>
        <br>
        <div class="profile-info">
            <button type="submit" class="large-rectangle small-text">
                Login
            </button>
            <a class="large-rectangle small-text" href="<?php echo e(route('register')); ?>">Register</a>
        </div>
        <br>
        <?php if(session('success')): ?>
            <p class="success">
                <?php echo e(session('success')); ?>

            </p>
        <?php endif; ?>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.homepage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/auth/login.blade.php ENDPATH**/ ?>