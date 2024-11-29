<a href="<?php echo e(route('showArticle', ['id' => $article->id])); ?>">
    <div class="long-article-container news-tile">
        <img src="<?php echo e(asset('images/article/' . $article->article_image)); ?>" alt="News Image">
        <div class="long-article-title-subtitle">
            <span class="article-title" ><?php echo e($article->title); ?></span>
            <div class="article-meta-container">
                <span class="small-text">By <?php echo e($article->author->display_name ?? 'Unknown'); ?></span>
                <span class="small-text">Created at: <?php echo e($article->create_date); ?></span>
                <span class="small-text">
                    <?php if($article->is_edited): ?>
                        Edited at: <?php echo e($article->edit_date); ?>

                    <?php else: ?>

                    <?php endif; ?>
                </span>
            </div>
            <span class="small-text">Total Votes: <?php echo e($article->upvotes - $article->downvotes); ?></span>
        </div>
        <div class="long-article-credits">
            <span><?php echo e($article->subtitle); ?></span>
        </div>
    </div>
</a><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/long_news_tile.blade.php ENDPATH**/ ?>