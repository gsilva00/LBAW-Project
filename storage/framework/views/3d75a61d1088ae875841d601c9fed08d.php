

<?php $__env->startSection('title', $article->is_deleted ? '[Deleted]' : $article->title); ?>

<?php $__env->startSection('content'); ?>
    <div class="article-more-news-wrapper">
        <section class="article-section">
            <div class="large-rectangle breadcrumbs">
                <a href="<?php echo e($previousUrl); ?>" class="thin"><?php echo e($previousPage); ?></a> >
                <a class="thin" href="<?php echo e(route('showTopic', ['name' => $topic->name])); ?>"><?php echo e($topic->name); ?></a> >
                <span class="thin"><?php echo e($article->is_deleted ? '[Deleted]' : $article->title); ?></span>
            </div>
            <div class="news-article">
                <h1 class="article-title border-bottom"><?php echo e($article->is_deleted ? '[Deleted]' : $article->title); ?></h1>
                <div class="article-credits">
                    <p class="small-text">
                        By
                        <?php if($article->is_deleted): ?>
                            Anonymous
                        <?php else: ?>
                            <a href="<?php echo e(route('profile', ['username' => $article->author->username])); ?>"><?php echo e($authorDisplayName); ?></a>
                        <?php endif; ?>
                    </p>
                    <p class="small-text">
                        <?php if($article->is_edited): ?>
                            Edited at: <?php echo e($article->edit_date); ?>

                        <?php else: ?>
                            Created at: <?php echo e($article->create_date); ?>

                        <?php endif; ?>
                    </p>
                    <button class="small-text small-rectangle" title="report news"><span>Report News</span></button>  <!-- Needs to be implemented -->
                </div>
                <p class="title"><?php echo e($article->is_deleted ? '[Deleted]' : $article->subtitle); ?></p>
                <div>
                    <img class="article-image" src="<?php echo e($article->is_deleted ? asset('images/article/default.jpg') : asset('images/article/' . $article->article_image)); ?>" alt="News Image">
                </div>
                <?php if($article->is_deleted): ?>
                    <p class="thin">[Deleted]</p>
                <?php else: ?>
                    <?php $__currentLoopData = $paragraphs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paragraph): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p class="thin"><?php echo e($paragraph); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                <div class="large-rectangle tags">
                    <span class="thin">Topic:</span>
                    <span><strong><a href="<?php echo e(route('showTopic', ['name' => $topic->name])); ?>"><?php echo e($topic->name); ?></a></strong></span>
                    <span class="thin">Tags:</span>
                    <?php $__currentLoopData = $articleTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span><strong><a href="<?php echo e(route('showTag', ['name' => $tag->name])); ?>"><?php echo e($tag->name); ?></a></strong></span><?php if(!$loop->last): ?><?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="article-actions">      
                        <?php if(Auth::check() && $user->favouriteArticles->contains($article->id)): ?>
                        <button class="small-rectangle fit-block favorite" title="Save Article"><i class='bx bxs-star'></i><span>Saved
                        <?php else: ?>
                        <button class="small-rectangle fit-block favorite" title="Save Article"><i class='bx bx-star'></i><span> Save Article
                        <?php endif; ?>
                    </span></button>
                    <div class="small-rectangle fit-block"><button title="upvote article"><i class='bx bx-upvote'></i></button><span><strong><?php echo e($article->upvotes - $article->downvotes); ?></strong></span><button title="downvote article"><i class='bx bx-downvote' ></i></button></div>
                </div>

                <div class="comments-section">
                    <h2>Comments</h2>
                    <form class="comment">
                        <?php if(Auth::guest() || $user->is_deleted): ?>
                            <img src="<?php echo e(asset('images/profile/default.jpg')); ?>" alt="profile_picture">
                        <?php else: ?>
                            <img src="<?php echo e(asset('images/profile/' . $user->profile_picture)); ?>" alt="profile_picture">
                        <?php endif; ?>
                        <div class="comment-input-container">
                            <input type="text" class="comment-input" placeholder="Write a comment..." <?php if(Auth::guest() || $user->is_deleted): ?> disabled <?php endif; ?>>

                            <button class="small-rectangle" title="Send comment" <?php if(Auth::guest() || $user->is_deleted): ?> disabled <?php endif; ?>><i class='bx bx-send remove-position'></i><span>Send</span></button>
                        </div>
                    </form>
                    <br>
                    <br>
                    <?php if($comments->isEmpty()): ?>
                        <div class="not-available-container">
                            <p>No comments available.</p>
                        </div>
                    <?php else: ?>
                        <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $__env->make('partials.comment', ['comment' => $comment, 'replies' => $comment->replies, 'user' => $user], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php if($comment->replies->isNotEmpty()): ?>
                                <button class="small-rectangle see-replies-button" title="See replies"><i class='bx bx-chevron-down remove-position' ></i><span><?php echo e($comment->replies->count()); ?> <?php echo e($comment->replies->count() > 1 ? 'Answers' : 'Answer'); ?></span></button>
                                <div class="reply">
                                <?php $__currentLoopData = $comment->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $__env->make('partials.comment', ['comment' => $reply], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <nav class="news-tab-section">
            <?php echo $__env->make('partials.trending_tags',['trendingTags' => $trendingTags], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('partials.recent_news',['recentNews' => $recentNews], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </nav>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/article_page.blade.php ENDPATH**/ ?>