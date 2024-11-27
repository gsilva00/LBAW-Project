<div class="pop-up">
    <i class='bx bx-error-circle'></i>
    <span class="error">
        <?php if(isset($field) && $errors->has($field)): ?>
            <?php echo e($errors->first($field)); ?>

        <?php elseif(session('error')): ?>
            <?php echo e(session('error')); ?>

        <?php endif; ?>
    </span>
    <button type="button" id="close-message-button" onclick="closeMessage()">
        <i class='bx bx-x'></i>
    </button>
</div><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/error_popup.blade.php ENDPATH**/ ?>