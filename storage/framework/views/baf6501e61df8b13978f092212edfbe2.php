

<?php $__env->startSection('title'); ?>
    <?php if($isOwner): ?>
        Your Profile
    <?php else: ?>
        <?php echo e($profileUser->display_name); ?>'s Profile
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="profile-wrapper" data-user-id="<?php echo e($profileUser->id); ?>">
        <section class="profile-container">
            <img src="<?php echo e(asset('images/profile/' . $profileUser->profile_picture)); ?>" alt="Your profile picture">
            <div class="profile-info">
                <h1><?php echo e($profileUser->display_name); ?>'s Profile</h1>
                <?php if($isOwner || $isAdmin): ?>
                    <a href="<?php echo e(route('editProfile', ['username' => $profileUser->username])); ?>" class="large-rectangle small-text greener">
                        Edit Profile
                    </a>
                <?php endif; ?>
                <?php if($isOwner && $user->is_banned): ?>
                    <button type="button" id="unban-appeal-button" class="large-rectangle small-text greener" data-action-url="<?php echo e(route('appealUnbanShow')); ?>">
                        Appeal Unban
                    </button>
                <?php endif; ?>
                <?php if(Auth::check() && !$isOwner): ?>
                    <button type="button" id="follow-user-button" class="large-rectangle small-text greener"
                            data-user-id="<?php echo e($user->id); ?>" data-profile-id="<?php echo e($profileUser->id); ?>">
                        <?php echo e(Auth::user()->isFollowingUser($profileUser->id) ? 'Unfollow User' : 'Follow User'); ?>

                    </button>
                    <button type="button" id="report-user-button" class="large-rectangle small-text greener">
                            Report User
                    </button>
                <?php endif; ?>
            </div>
            <div id="rest-profile-info">
                <?php if($isOwner): ?>
                    <span class="small-text"> Your username:</span>
                    <span><strong> <?php echo e($profileUser->username); ?> </strong></span>
                <?php endif; ?>
                <div class="profile-info">
                <p class="small-text">Reputation:</p>
                <?php if( $profileUser->reputation == 0): ?>
                    <i class='bx bx-dice-1'></i>
                <?php elseif($profileUser->reputation == 1): ?>
                    <i class='bx bx-dice-2'></i>
                <?php elseif($profileUser->reputation == 2): ?>
                    <i class='bx bx-dice-3'></i>
                <?php elseif($profileUser->reputation == 3): ?>
                    <i class='bx bx-dice-4'></i>
                <?php elseif($profileUser->reputation == 4): ?>
                    <i class='bx bx-dice-5'></i>
                <?php else: ?>
                    <i class='bx bx-dice-6'></i>
                <?php endif; ?>
                </div>
                <p class="small-text">Description:</p>
                <span><?php echo e($profileUser->description); ?></span>
            </div>
            </section>
            <?php if($isOwner || $isAdmin): ?>
            <section>
                <h2 id="favouriteTopicTitle">Favourite Topics</h2>
                <?php if($profileUser->followedTopics->isEmpty()): ?>
                    <div class="not-available-container">
                        <p>No favourite topics.</p>
                    </div>
                <?php else: ?>
                        <div class="selected">
                    <?php $__currentLoopData = $profileUser->followedTopics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="block">
                            <span><?php echo e($topic->name); ?></span><button class="remove" data-url="<?php echo e(route('unfollowTopic', $topic->name)); ?>" data-topic-id="<?php echo e($topic->id); ?>">&times;</button>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                <?php endif; ?>
            </section>
            <section>
                <h2 id="favouriteTagTitle">Favourite Tags</h2>
                <?php if($profileUser->getFollowedTags()->isEmpty()): ?>
                    <div class="not-available-container">
                        <p>No favourite tags.</p>
                    </div>
                <?php else: ?>
                    <div class="selected">
                        <?php $__currentLoopData = $profileUser->getFollowedTags(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="block">
                                <span><?php echo e($tag->name); ?></span><button class="remove" data-url="<?php echo e(route('unfollowTag', $tag->name)); ?>" data-tag-id="<?php echo e($tag->id); ?>">&times;</button>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </section>

            <section>
                <h2>Favourite Authors</h2>
                <?php if($profileUser->following->isEmpty()): ?>
                <div class="not-available-container">
                        <p>No favourite authors.</p>
                    </div>
                <?php else: ?>
                <div id="users-section">
                    <div id="user-list">
                            <?php $__currentLoopData = $profileUser->following; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fav_author): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo $__env->make('partials.user_tile', ['user' => $fav_author, 'isAdminPanel' => false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                <button type="button" onclick="window.location='<?php echo e(route('createArticle')); ?>'" class="large-rectangle small-text">
                    Create New Article
                </button>
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