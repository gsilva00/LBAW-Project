<section id="recent-news-section">
<p class="title">Most Recent News</p>
<?php if($recentNews->isNotEmpty()): ?>
                <?php $__currentLoopData = $recentNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="news-tile">
                    <a href="<?php echo e(route('news.show', ['id' => $news->id])); ?>">
                        <img src="https://picsum.photos/seed/picsum/200/300" alt="News Image" style="width: 100%; height: auto;">
                        <p class="title"><?php echo e($news->title); ?></p>
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <p>No recent news available.</p>
        <?php endif; ?>
</section><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/recent_news.blade.php ENDPATH**/ ?>