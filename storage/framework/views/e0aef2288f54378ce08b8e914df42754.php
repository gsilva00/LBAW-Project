<?php if(session('success')): ?>
    <div class="success">
        <span>
            <?php echo e(session('success')); ?>

        </span>
        <button type="button" id="close-message-button" onclick="closeMessage()">
            <i class='bx bx-x'></i>
        </button>
    </div>
<?php endif; ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/success_message.blade.php ENDPATH**/ ?>