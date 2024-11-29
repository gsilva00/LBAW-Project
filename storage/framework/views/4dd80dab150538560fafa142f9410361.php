<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
    <head>
        <!-- Metadata -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"> <!-- CSRF Token No clue if needed it was on layout.app -->
        <!-- Styles -->
        <title>
            <?php if (! empty(trim($__env->yieldContent('title')))): ?>
                <?php echo $__env->yieldContent('title'); ?> - <?php echo e(config('app.name', 'Laravel')); ?>

            <?php else: ?>
                <?php echo e(config('app.name', 'Laravel')); ?>

            <?php endif; ?>
        </title>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link href="<?php echo e(url('css/userfeed.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/comments.css')); ?>" rel="stylesheet">
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
        <!-- Scripts -->
        <script src="<?php echo e(url('js/dropdown.js')); ?>" defer> </script>
        <script src="<?php echo e(url('js/searchdropdown.js')); ?>" defer> </script>
        <script src="<?php echo e(url('js/filterdropdowntag.js')); ?>" defer> </script>
        <script src="<?php echo e(url('js/filterdropdowntopic.js')); ?>" defer> </script>
        <script src="<?php echo e(url('js/adminpanel.js')); ?>" defer></script>
        <script src="<?php echo e(url('js/userfeed.js')); ?>" defer></script>
        <script src="<?php echo e(url('js/popup.js')); ?>"> </script>
        <script src="<?php echo e(url('js/replies.js')); ?>"> </script>
        <script src="<?php echo e(url('js/unfollowtag.js')); ?>"> </script>
        <script src="<?php echo e(url('js/unfollowtopic.js')); ?>"> </script>
    </head>
    <body>
        <div class="wrapper">
            <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <main class="content">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
            <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </body>
</html><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/layouts/app.blade.php ENDPATH**/ ?>