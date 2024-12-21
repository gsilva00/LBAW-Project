<header>
    <div id="top-part-header">
        <h1><a href="<?php echo e(route('homepage')); ?>" class="logo"> <?php echo e(config('app.name', 'Laravel')); ?></a></h1>
        <a href="<?php echo e(route('userFeed')); ?>" class="<?php echo e(Route::currentRouteName() == 'userFeed' ? 'active' : ''); ?>">
            <h2><i class='bx bx-book'></i> User Feed</h2>
        </a>
        <div id="profile" class="dropdown">
            <?php if(Auth::check()): ?>
                <button type="button" id="profile-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class='bx bx-user-circle'></i>
                    <h2><?php echo e($user->username); ?></h2>
                </button>
                <div class="dropdown-menu" aria-labelledby="profile-button">
                    <a class="dropdown-item <?php echo e(Route::currentRouteName() == 'profile' ? 'active' : ''); ?>" href="<?php echo e(route('profile', ['username' => $user->username])); ?>"><h2>See Profile</h2></a>
                    <a class="dropdown-item <?php echo e(Route::currentRouteName() == 'notifications.show.page' ? 'active' : ''); ?>" href="<?php echo e(route('notifications.show.page')); ?>"><h2>Notifications</h2></a>
                    <a class="dropdown-item <?php echo e(Route::currentRouteName() == 'showFavouriteArticles' ? 'active' : ''); ?>" href="<?php echo e(route('showFavouriteArticles')); ?>"><h2>Favourite Articles</h2></a>
                    <?php if($user->is_admin): ?>
                        <a class="dropdown-item <?php echo e(Route::currentRouteName() == 'adminPanel' ? 'active' : ''); ?>" href="<?php echo e(route('adminPanel')); ?>"><h2>Administrator Panel</h2></a>
                    <?php endif; ?>
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><h2>Logout</h2></a>
                </div>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
            <?php else: ?>
                <button type="button" id="profile-button" onclick="window.location='<?php echo e(route('login')); ?>'">
                    <i class='bx bx-user-circle'></i><h2>Login</h2>
                </button>
            <?php endif; ?>
        </div>
    </div>
    <div id="bottom-part-header">
        <a class="<?php echo e(Route::currentRouteName() == 'homepage' ? 'active' : ''); ?>" href="<?php echo e(route('homepage')); ?>"><h2><i class='bx bx-home-alt'></i> Homepage</h2></a>
        <a class="<?php echo e(Route::currentRouteName() == 'showRecentNews' ? 'active' : ''); ?>" href="<?php echo e(route('showRecentNews')); ?>"><h2><i class='bx bx-stopwatch'></i>Most Recent News</h2></a>
        <a class="<?php echo e(Route::currentRouteName() == 'showMostVotedNews' ? 'active' : ''); ?>" href="<?php echo e(route('showMostVotedNews')); ?>"><h2><i class='bx bx-sort'></i> Most Voted News</h2></a>
        <a class="<?php echo e(Route::currentRouteName() == 'showTrendingTags' ? 'active' : ''); ?>" href="<?php echo e(route('showTrendingTags')); ?>"><h2><i class='bx bx-trending-up'></i>Trending Tags</h2></a>
        <h2 class="topic">
            <a href="<?php echo e(route('showTopic', ['name' => 'Politics'])); ?>" class="<?php echo e(Route::currentRouteName() == 'showTopic' && Route::input('name') == 'Politics' ? 'active' : ''); ?>">Politics</a>
        </h2>
        <h2 class="topic">
            <a href="<?php echo e(route('showTopic', ['name' => 'Business'])); ?>" class="<?php echo e(Route::currentRouteName() == 'showTopic' && Route::input('name') == 'Business' ? 'active' : ''); ?>">Business</a>
        </h2>
        <h2 class="topic">
            <a href="<?php echo e(route('showTopic', ['name' => 'Technology'])); ?>" class="<?php echo e(Route::currentRouteName() == 'showTopic' && Route::input('name') == 'Technology' ? 'active' : ''); ?>">Technology</a>
        </h2>
        <h2 class="topic">
            <a href="<?php echo e(route('showTopic', ['name' => 'Science'])); ?>" class="<?php echo e(Route::currentRouteName() == 'showTopic' && Route::input('name') == 'Science' ? 'active' : ''); ?>">Science</a>
        </h2>
        <button class="h2" type="button" id="all-topics-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class='bx bx-news'></i>
            <span>All Topics</span>
        </button>
        <div class="dropdown-menu" aria-labelledby="all-topics-button">
            <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a class="dropdown-item <?php echo e(Route::currentRouteName() == 'showTopic' && Route::input('name') == $topic->name ? 'active' : ''); ?>" href="<?php echo e(route('showTopic', ['name' => $topic->name])); ?>"><h2><?php echo e($topic->name); ?></h2></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php echo $__env->make('partials.search',['tags' => $tags, 'topics' => $topics], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</header><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/layouts/header.blade.php ENDPATH**/ ?>