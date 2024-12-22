<footer>
    <a class="<?php echo e(Route::currentRouteName() == 'features' ? 'active' : ''); ?>" href="<?php echo e(route('features')); ?>"><h2>Features</h2></a>
    <a class="<?php echo e(Route::currentRouteName() == 'contacts' ? 'active' : ''); ?>" href="<?php echo e(route('contacts')); ?>">
        <h2>Contacts</h2>
    </a>
    <a class="<?php echo e(Route::currentRouteName() == 'aboutUs' ? 'active' : ''); ?>" href="<?php echo e(route('aboutUs')); ?>"><h2>About Us</h2></a>
    <h2 id="rights-reserved"><?php echo e(config('app.name', 'Laravel')); ?>, 2024 <i class='bx bx-copyright' ></i> All rights reserved</h2>
</footer><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/layouts/footer.blade.php ENDPATH**/ ?>