<div class="border-bottom">
    <a href="<?php echo e(route('article.show', ['id' => $article->id])); ?>">
    <img id="first-image" src="https://picsum.photos/seed/picsum/1200/1300" alt="News Image">
    <div class="news-article">
        <span class="article-title" ><?php echo e($article->title); ?></span>
        <span><?php echo e($article->subtitle); ?></span>
    </div>
    </a>
</div><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/first_tile.blade.php ENDPATH**/ ?>