<div class="border-bottom">
    <a href="<?php echo e(route('showArticle', ['id' => $article->id])); ?>">
        <img class="article-image" src="<?php echo e(asset('images/article/' . $article->article_image)); ?>" alt="News Image">
        <div class="news-article">
            <span class="article-title" ><?php echo e($article->title); ?></span>
            <span><?php echo e($article->subtitle); ?></span>
        </div>
    </a>
</div><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/first_tile.blade.php ENDPATH**/ ?>