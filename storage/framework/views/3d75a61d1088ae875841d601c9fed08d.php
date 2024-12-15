

<?php $__env->startSection('title', $article->is_deleted ? '[Deleted]' : $article->title); ?>

<?php $__env->startSection('content'); ?>
    <meta name="article-id" content="<?php echo e($article->id); ?>">
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
                    <button class="small-text small-rectangle" title="report article" id="report-article-button" data-article-id="<?php echo e($article->id); ?>">
                        <span>Report Article</span> <!-- Needs to be implemented -->
                    </button>
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
                    <button class="small-rectangle fit-block favourite" title="Favourite Article" data-favourite-url="<?php echo e(route('favouriteArticle', ['id' => $article->id])); ?>">
                        <?php if(Auth::check() && $favourite): ?>
                            <i class='bx bxs-star'></i>
                            <span>Favourited</span>
                        <?php else: ?>
                            <i class='bx bx-star'></i>
                            <span>Favourite Article</span>
                        <?php endif; ?>
                    </button>
                    <div class="fit-block large-rectangle article-votes">
                        <button id="upvote-button" data-upvote-url="<?php echo e(route('upvoteArticle', ['id' => $article->id])); ?>">
                            <?php if($voteArticle == 1): ?>
                                <i class='bx bxs-upvote'></i>
                            <?php else: ?>
                                <i class='bx bx-upvote'></i>
                            <?php endif; ?>
                        </button>
                        <p><strong><?php echo e($article->upvotes - $article->downvotes); ?></strong></p>
                        <button id="downvote-button" data-downvote-url="<?php echo e(route('downvoteArticle', ['id' => $article->id])); ?>">
                            <?php if($voteArticle == -1): ?>
                                <i class='bx bxs-downvote'></i>
                            <?php else: ?>
                                <i class='bx bx-downvote'></i>
                            <?php endif; ?>
                        </button>
                    </div>
                </div>

                <div class="comments-section">
                    <h2>Comments</h2>
                    <?php echo $__env->make('partials.comment_write_form', ['user' => $user, 'article' => $article, 'state' => "writeArticleComment"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <br>
                    <br>
                    <div class="comments-list">
                        <?php echo $__env->make('partials.comments', ['comments' => $comments, 'user' => $user, 'article' => $article], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
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