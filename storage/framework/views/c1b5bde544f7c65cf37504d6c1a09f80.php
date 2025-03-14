<div class="news-tile">
    <a href="<?php echo e(route('showArticle', ['id' => $article->id])); ?>">
        <img src="<?php echo e(asset('images/article/' . $article->article_image)); ?>" alt="<?php echo e($article->title); ?>'s main image">
        <p class="title"><?php echo e($article->title); ?></p>
    </a>
    <?php if(!$article->is_deleted && Auth::check() && Auth::user()->id === $article->author_id): ?>
        <div class="float-container">
            <button type="button" class="large-rectangle small-text greener" onclick="window.location='<?php echo e(route('editArticle', ['id' => $article->id])); ?>'">Edit</button>
            <form action="<?php echo e(route('deleteArticle', ['id' => $article->id])); ?>" method="POST" style="display:inline;">
                <?php echo csrf_field(); ?>
                <button type="submit" class="large-rectangle small-text greener">Delete</button>
            </form>
        </div>
    <?php endif; ?>
</div><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/news_tile.blade.php ENDPATH**/ ?>