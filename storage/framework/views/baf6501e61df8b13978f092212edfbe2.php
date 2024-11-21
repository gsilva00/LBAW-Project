

<?php $__env->startSection('content'); ?>
    <div class="profile-wrapper">
        <section class="profile-container">
            <img src="https://picsum.photos/seed/picsum/200/300" alt="News Image">
        <div class="profile-info">
        <h1><?php echo e($displayName); ?>'s Profile</h1>
        <?php if($isOwner || $isAdmin): ?>
            <a href="<?php echo e(route('profile.edit')); ?>"><button class="large-rectangle small-text greyer">Edit Profile</button></a>  <!--Need to do action here IF ITS ADMIN EDITING NOT ITS OWN ACCOUNT -->
        <?php endif; ?>
        <?php if($isAdmin): ?>
            <button class="large-rectangle small-text greyer">
            <?php if($isBanned): ?>
                Unban User  <!--Need to do action here -->
            <?php else: ?>
                Ban User    <!--Need to do action here -->
            <?php endif; ?>
            </button>

            <button class="large-rectangle small-text greyer"> Delete User </button>  <!--Need to do action here -->
        <?php endif; ?>
        </div>
        <div id="rest-profile-info">
        <?php if($isOwner): ?>
        <span class="small-text"> Your username:</span>
        <span><strong> <?php echo e($profileUsername); ?> </strong></span>
        <?php endif; ?>

        <p class="small-text">Description:</p>
        <span><?php echo e($description); ?></span>
        </div>
</section>

    <div class="profile-info">
        <?php if($isOwner): ?>
            <h2> Your articles</h2>
        <?php else: ?>
            <h2> Articles by <?php echo e($displayName); ?></h2>
        <?php endif; ?>

        <?php if($isOwner): ?>
            <a href="<?php echo e(route('profile.edit')); ?>"><button class="large-rectangle small-text greyer">Create New Article</button></a>  <!--Need to do action here -->
        <?php endif; ?>

    </div>


    <?php if($ownedArticles->isNotEmpty()): ?>
    <div class="sec-articles">
    <?php $__currentLoopData = $ownedArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('partials.news_tile', [
                'article' => $article,
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php else: ?>
        <div class="not-available-container">
            <p>No articles available.</p>
        </div>
    <?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.homepage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/profile.blade.php ENDPATH**/ ?>