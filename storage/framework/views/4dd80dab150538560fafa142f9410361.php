<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
    <head>
        <!-- Metadata -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"> <!-- CSRF Token No clue if needed it was on layout.app -->
        <title>
            <?php if (! empty(trim($__env->yieldContent('title')))): ?>
                <?php echo $__env->yieldContent('title'); ?> - <?php echo e(config('app.name', 'Laravel')); ?>

            <?php else: ?>
                <?php echo e(config('app.name', 'Laravel')); ?>

            <?php endif; ?>
        </title>
        <!-- Styles -->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link href="<?php echo e(url('css/user_feed.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/comments.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/header.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/footer.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/login.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/recent_news.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/trending_tag.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/article_page.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/contacts.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/profile.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/filter.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/popup.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/app.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(url('css/modal.css')); ?>" rel="stylesheet">
        <!-- Scripts -->
        <script src="<?php echo e(url('js/dropdown.js')); ?>" defer> </script>
        <script src="<?php echo e(url('js/dropdown_tag_filter.js')); ?>" defer> </script>
        <script src="<?php echo e(url('js/dropdown_topic_filter.js')); ?>" defer> </script>
        <script src="<?php echo e(url('js/admin_panel.js')); ?>" defer></script>
        <script src="<?php echo e(url('js/user_feed.js')); ?>" defer></script>
        <script src="<?php echo e(url('js/popup.js')); ?>" defer> </script>
        <script src="<?php echo e(url('js/unfollow_tag.js')); ?>" defer> </script>
        <script src="<?php echo e(url('js/unfollow_topic.js')); ?>" defer> </script>
        <script src="<?php echo e(url('js/tag_create_article.js')); ?>" defer></script>
        <script src="<?php echo e(url('js/tag_edit_article.js')); ?>" defer></script>
        <script src="<?php echo e(url('js/article_interact.js')); ?>" defer> </script>
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