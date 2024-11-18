<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(config('app.name', 'Laravel')); ?></title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="<?php echo e(url('js/dropdown.js')); ?>"> </script>
    <link href="<?php echo e(url('css/app.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(url('css/header.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(url('css/footer.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(url('css/contacts.css')); ?>" rel="stylesheet">
    <!--  <link href="<?php echo e(url('css/app.css')); ?>" rel="stylesheet"> -->
</head>
<body>
    <?php echo $__env->make('pages.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<main>
    <?php echo $__env->yieldContent('content'); ?>
</main>
    <?php echo $__env->make('pages.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/layouts/homepage.blade.php ENDPATH**/ ?>