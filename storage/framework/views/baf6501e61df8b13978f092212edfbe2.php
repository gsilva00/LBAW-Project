

<?php $__env->startSection('title'); ?>
    <?php if($isOwner): ?>
        Your Profile
    <?php else: ?>
        <?php echo e($profileUser->display_name); ?>'s Profile
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="profile-wrapper">
        <section class="profile-container">
            <img src="<?php echo e(asset('images/profile/' . $profileUser->profile_picture)); ?>" alt="profile_picture">
            <div class="profile-info">
                <h1><?php echo e($profileUser->display_name); ?>'s Profile</h1>
                <?php if($isOwner || $isAdmin): ?>
                    <a href="<?php echo e(route('editProfile', ['username' => $profileUser->username])); ?>">
                        <button class="large-rectangle small-text greyer">Edit Profile</button>
                    </a>
                <?php endif; ?>
                <?php if(Auth::check() && !$isOwner): ?>
                <form id="follow-user-form" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="button" id="follow-user-button" class="large-rectangle small-text greyer">
                        <?php echo e(Auth::user()->isFollowing($user) ? 'Unfollow User' : 'Follow User'); ?>

                    </button>
                </form>
                <?php endif; ?>
            </div>
            <div id="rest-profile-info">
                <?php if($isOwner): ?>
                    <span class="small-text"> Your username:</span>
                    <span><strong> <?php echo e($profileUser->username); ?> </strong></span>
                <?php endif; ?>

                <p class="small-text">Description:</p>
                <span><?php echo e($profileUser->description); ?></span>
            </div>
            </section>
            <?php if($isOwner || $isAdmin): ?>
            <section>
                <h2 id="favoriteTopicTitle">Favorite Topics</h2>
                <?php if($profileUser->followedTopics->isEmpty()): ?>
                    <div class="not-available-container">
                        <p>No favorite topics.</p>
                    </div>
                <?php else: ?>
                        <div class="selected">
                    <?php $__currentLoopData = $profileUser->followedTopics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="block">
                            <span><?php echo e($topic->name); ?></span><button class="remove" data-url="<?php echo e(route('topic.unfollow', $topic)); ?>" data-topic-id="<?php echo e($topic->id); ?>">&times;</button>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                <?php endif; ?>
            </section>
            <section>
                <h2 id="favoriteTagTitle">Favorite Tags</h2>
                <?php if($profileUser->followedTags->isEmpty()): ?>
                    <div class="not-available-container">
                        <p>No favorite tags.</p>
                    </div>
                <?php else: ?>
                    <div class="selected">
                        <?php $__currentLoopData = $profileUser->followedTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="block">
                                <span><?php echo e($tag->name); ?></span><button class="remove" data-url="<?php echo e(route('tag.unfollow', $tag)); ?>" data-tag-id="<?php echo e($tag->id); ?>">&times;</button>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </section>

            <section>
                <h2>Favorite Authors</h2>
                <?php if($profileUser->following->isEmpty()): ?>
                <div class="not-available-container">
                        <p>No favorite authors.</p>
                    </div>
                <?php else: ?>
                <div id="users-section">
                <div id="user-list">
                        <?php $__currentLoopData = $profileUser->following; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $favauthor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $__env->make('partials.user_tile', ['user' => $favauthor], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                </div>
                <?php endif; ?>
            </section>
        <?php endif; ?>
        <div class="profile-info">
            <?php if($isOwner): ?>
                <h2> Your articles</h2>
            <?php else: ?>
                <h2> Articles by <?php echo e($profileUser->display_name); ?></h2>
            <?php endif; ?>

            <?php if($isOwner): ?>
                <a href="<?php echo e(route('createArticle')); ?>">
                    <button class="large-rectangle small-text">Create New Article</button>
                </a>
            <?php endif; ?>

        </div>

        <?php if($ownedArticles->isNotEmpty()): ?>
            <div class="sec-articles profile-page">
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/profile.blade.php ENDPATH**/ ?>