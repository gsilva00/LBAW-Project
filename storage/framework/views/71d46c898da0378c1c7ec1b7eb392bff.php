<?php if(session('success')): ?>
    <?php echo $__env->make('partials.success_message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <!-- TODO: Change to success_popup -->
<?php endif; ?>

<?php if($errors->any()): ?>
    <?php echo $__env->make('partials.error_popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/layouts/user_feedback.blade.php ENDPATH**/ ?>