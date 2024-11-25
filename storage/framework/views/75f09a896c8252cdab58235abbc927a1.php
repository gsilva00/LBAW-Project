<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <!-- CSRF Token No clue if needed it was on layout.app -->
         <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title><?php echo e(config('app.name', 'Laravel')); ?></title>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <script src="<?php echo e(url('js/dropdown.js')); ?>" defer> </script>
        <script src="<?php echo e(url('js/searchdropdown.js')); ?>" defer> </script>
        <script src="<?php echo e(url('js/filterdropdowntag.js')); ?>" defer> </script>
        <script src="<?php echo e(url('js/filterdropdowntopic.js')); ?>" defer> </script>
        <script src="<?php echo e(url('js/adminpanel.js')); ?>" defer></script>
        <script src="<?php echo e(url('js/userfeed.js')); ?>" defer></script>
        <script src="<?php echo e(url('js/tagcreatearticle.js')); ?>"> </script>
        <script src="<?php echo e(url('js/popup.js')); ?>"> </script>
        <link href="<?php echo e(url('css/userfeed.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/header.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/footer.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/login.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/recentnews.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/trendingtag.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/articlepage.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/contacts.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/profile.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/filter.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/popup.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/app.css')); ?>" rel="stylesheet">
    </head>
    <body>
        <div class="wrapper">
            <?php echo $__env->make('pages.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <main class="content">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
            <?php echo $__env->make('pages.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </body>
</html><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/layouts/homepage.blade.php ENDPATH**/ ?>