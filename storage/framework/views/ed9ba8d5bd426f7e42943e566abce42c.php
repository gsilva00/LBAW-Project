<header>
    <div id="top-part-header">
        <h1><a href="<?php echo e(route('homepage')); ?>" class="logo"> <?php echo e(config('app.name', 'Laravel')); ?></a></h1>
        <h2><i class='bx bx-heart'></i> Followed Authors' News</h2>
        <a href="<?php echo e(route('followingTags')); ?>">
            <h2><i class='bx bx-purchase-tag'></i> Followed Tags</h2>
        </a>
        <a href="<?php echo e(route('followingTopics')); ?>">
            <h2><i class='bx bx-book'></i> Followed Topics</h2>
        </a>
        <div id="profile" class="dropdown">
            <?php if(Auth::check()): ?>
                <button type="button" id="profile-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class='bx bx-user-circle'></i>
                    <h2><?php echo e($user->username); ?></h2>
                </button>
                <div class="dropdown-menu" aria-labelledby="profile-button">
                    <a class="dropdown-item" href="<?php echo e(route('profile', ['username' => $user->username])); ?>"><h2>See Profile</h2></a>
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><h2>Logout</h2></a>
                    <?php if($user->is_admin): ?>
                        <a class="dropdown-item" href="#"><h2>Something for admin</h2></a>
                    <?php endif; ?>
                </div>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="GET" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
            <?php else: ?>
                <a id="profile-button" href="<?php echo e(route('login')); ?>">
                    <i class='bx bx-user-circle'></i><h2>Login</h2>
                </a>
            <?php endif; ?>
        </div>  <!-- Needs to be change to get login/logout -->
    </div>
    <div id="bottom-part-header">
        <a href="<?php echo e(route('homepage')); ?>"><h2><i class='bx bx-home-alt'></i> Homepage</h2></a>
        <a href="<?php echo e(route('recentnews.show')); ?>"><h2><i class='bx bx-stopwatch'></i>Most Recent News</h2></a>
        <a href="<?php echo e(route('votednews.show')); ?>"><h2><i class='bx bx-sort'></i> Most Voted News</h2></a>
        <h2><i class='bx bx-trending-up'></i>Trending Tags</h2>
        <h2 class="topic">
            <a href="<?php echo e(route('search.show', ['topics' => ['Politics']])); ?>">Politics</a>
        </h2>
        <h2 class="topic">
            <a href="<?php echo e(route('search.show', ['topics' => ['Business']])); ?>">Business</a>
        </h2>
        <h2 class="topic">
            <a href="<?php echo e(route('search.show', ['topics' => ['Technology']])); ?>">Technology</a>
        </h2>
        <h2 class="topic">
            <a href="<?php echo e(route('search.show', ['topics' => ['Science']])); ?>">Science</a>
        </h2>
        <h2><i class='bx bx-news'></i>All Topics</h2>
        <?php echo $__env->make('partials.search',['tags' => $tags, 'topics' => $topics], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</header><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/header.blade.php ENDPATH**/ ?>