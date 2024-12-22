<div class="error-pop-up">
    <i class='bx bx-error-circle'></i>
    <span class="error">
        <?php if($errors->any()): ?>
            <?php echo e($errors->first()); ?>

        <?php endif; ?>
    </span>
    <button type="button" id="close-message-button" onclick="closeMessage()">
        <i class='bx bx-x'></i>
    </button>
</div><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/error_popup.blade.php ENDPATH**/ ?>