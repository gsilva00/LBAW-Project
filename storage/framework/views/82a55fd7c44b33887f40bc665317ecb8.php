

<?php $__env->startSection('title', 'Edit Article'); ?>

<?php $__env->startSection('content'); ?>
    <div class="profile-wrapper">
        <h1 class="large-rectangle">Edit a New Article</h1>
        <form class="large-rectangle" action="<?php echo e(route('updateArticle', ['id' => $article->id])); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <br>
            <div class="profile-info">
                <label for="title"><span>Title</span></label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo e($article->title); ?>" placeholder="title" required>
            </div>
            <br>
            <div class="profile-info">
                <label for="subtitle"><span>Subtitle</span></label>
                <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?php echo e($article->subtitle); ?>" placeholder="subtitle" required>
            </div>
            <br>
            <div class="profile-info">
                <label for="content"><span>Content</span></label>
                <textarea class="form-control" id="content" name="content" rows="10" placeholder="content" required><?php echo e($article->content); ?></textarea>
            </div>
            <br>
            <div class="profile-info">
                <label for="tag-create-article-input"><span>Tags</span></label>
                <input type="text" id="tag-create-article-input" placeholder="Type to search tags...">
                <div id="tag-create-article-suggestions" class="suggestions"></div>
            </div>
            <div id="selected-create-article-tags" class="selected selected-maxwidth"></div>
            <div class="profile-info">
                <label for="content"><span>Topics</span></label>
                <select class="form-control" id="topics" name="topics[]" required>
                    <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($topic->id); ?>" <?php echo e($article->topic_id == $topic->id ? 'selected' : ''); ?>><?php echo e($topic->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <br>
            <div class="profile-info">
                <label for="article_picture"><span>Upload Article Picture</span></label>
                <input type="file" name="file" id="article_picture">
            </div>
            <?php if($errors->has('article_picture')): ?>
                <?php echo $__env->make('partials.error_popup', ['field' => 'article_picture'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <br>
            <br>
            <br>
            <div class="profile-info">
                <span>Save your article before leaving: </span>
                <button type="submit" class="large-rectangle small-text greyer">Save Changes</button>
            </div>
            <br>
        </form>
    </div>
    <br>
    <br>
    <script>
        window.initialTags = <?php echo json_encode($article->tags, 15, 512) ?>;
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/edit_article.blade.php ENDPATH**/ ?>