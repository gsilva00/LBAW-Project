

<?php $__env->startSection('content'); ?>
<div class="profile-wrapper login-register-container">
<form method="POST" action="<?php echo e(route('register')); ?>">
    <?php echo e(csrf_field()); ?>

    <h1>Register</h1>
    <div class="profile-info space-between">
    <label for="Username"><span>Username</span></label>
    <input id="username" type="text" name="username" value="<?php echo e(old('username')); ?>" required autofocus autocomplete="off">
    <?php if($errors->has('username')): ?>
      <span class="error">
          <?php echo e($errors->first('username')); ?>

      </span>
    <?php endif; ?>
    </div>
    <br>
    <div class="profile-info space-between">
    <label for="email"><span>E-Mail</span></label>
    <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email">
    <?php if($errors->has('email')): ?>
      <span class="error">
          <?php echo e($errors->first('email')); ?>

      </span>
    <?php endif; ?>
    </div>
    <br>
    <div class="profile-info space-between">
    <label for="password"><span>Password</span></label>
    <input id="password" type="password" name="password" required>
    <?php if($errors->has('password')): ?>
      <span class="error">
          <?php echo e($errors->first('password')); ?>

      </span>
    <?php endif; ?>
    </div>
    <br>
    <div class="profile-info space-between">
    <label for="password-confirm"><span>Confirm Password</span></label>
    <input id="password-confirm" type="password" name="password_confirmation" required>
    </div>
    <br>
    <div class="profile-info">
    <button type="submit" class="large-rectangle small-text">
      Register
    </button>
    <a class="large-rectangle small-text" href="<?php echo e(route('login')); ?>">Login</a>
    </div>
</form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.homepage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/auth/register.blade.php ENDPATH**/ ?>