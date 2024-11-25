<div class="news-tile">
    <a href="<?php echo e(route('article.show', ['id' => $article->id])); ?>">
        <img src="https://picsum.photos/seed/picsum/200/300" alt="News Image" style="width: 100%;">
        <p class="title"><?php echo e($article->title); ?></p>
    </a>
<<<<<<< HEAD
    <?php if(!$article->is_deleted && Auth::check() && Auth::user()->id === $article->author_id): ?>
    <div class="float-container">
        <a href="<?php echo e(route('editArticle', ['id' => $article->id])); ?>" class="large-rectangle small-text"><span>Edit</span></a>
        <form action="<?php echo e(route('deleteArticle', ['id' => $article->id])); ?>" method="POST" style="display:inline;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="large-rectangle small-text greyer"><span>Delete</span></button>
        </form>
    </div>
    <?php endif; ?>
=======
>>>>>>> origin/gabriel
</div><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/news_tile.blade.php ENDPATH**/ ?>