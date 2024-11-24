<div class="news-tile">
    <a href="<?php echo e(route('article.show', ['id' => $article->id])); ?>">
        <img src="<?php echo e(asset('images/article/' . $article->article_image)); ?>" alt="News Image">
        <p class="title"><?php echo e($article->title); ?></p>
    </a>
    <?php if(!$article->is_deleted): ?>
    <div class="float-container">
    <button class="large-rectangle small-text"><span>Edit</span></button>
    <button class="large-rectangle small-text greyer"><span>Delete</span></button>
    </div>
    <?php endif; ?>
</div><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/news_tile.blade.php ENDPATH**/ ?>