

<?php $__env->startSection('content'); ?>
    <div class="article-more-news-wrapper">
    <section class="article-section">
    <div class="large-rectangle breadcrumbs">
        <a href="<?php echo e($previousUrl); ?>" class="thin"><?php echo e($previousPage); ?></a> >
        <span class="thin"><?php echo e($topic->name); ?></span> >
        <span class="thin"><?php echo e($article->title); ?></span>
    </div>
    <div class="news-article">
        <h1 class="article-title border-bottom" ><?php echo e($article->title); ?></h1>
        <div class="article-credits">
            <p class="small-text">By <?php echo e($authorDisplayName); ?></p>
            <p class="small-text">Created at: <?php echo e($article->create_date); ?></p>
            <p class="small-text">
            <?php if($article->is_edited): ?>
            Edited at: <?php echo e($article->edit_date); ?>

            <?php else: ?>
                
            <?php endif; ?>
            </p>
            <button id="report-button" class="large-rectangle small-text"><span>Report News</span></button>
        </div>
        <p class="title"><?php echo e($article->subtitle); ?></p>
        <div>
            <img class="article-image" src="https://picsum.photos/seed/picsum/1200/1300" alt="News Image">
        </div>
        <p class="article-text border-bottom"><?php echo e($article->content); ?></p>
        <div class="large-rectangle tags">
            <span class="thin">Topic:</span>
            <span><strong><a href="<?php echo e(route('search.show', ['topics' => [$topic->name]])); ?>"><?php echo e($topic->name); ?></a></strong></span>
            <span class="thin">Tags:</span>
            <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span><strong><a href="<?php echo e(route('search.show', ['tags' => [$tag->name]])); ?>"><?php echo e($tag->name); ?></a></strong></span><?php if(!$loop->last): ?><?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <div class="large-rectangle article-votes"><button><i class='bx bx-upvote'></i></button><p><strong><?php echo e($article->upvotes - $article->downvotes); ?></strong></p><button><i class='bx bx-downvote' ></i></button></div>
    

        <div class="comments-section">
            <h2>Comments</h2>
            <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('partials.comment', ['comment' => $comment], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    </section>
    <section class="news-tab-section">
        <?php echo $__env->make('partials.trending_tags',['trendingTags' => $trendingTags], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('partials.recent_news',['recentNews' => $recentNews], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </section>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.homepage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/articlePage.blade.php ENDPATH**/ ?>