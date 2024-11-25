

<?php $__env->startSection('title', 'Create Article'); ?>

<?php $__env->startSection('content'); ?>
    <div class="profile-wrapper">
        <h1 class="large-rectangle">Create a New Article</h1>

            <form id="create-article" class="large-rectangle" action="<?php echo e(route('submitArticle')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <br>
                <div class="profile-info">
                    <label for="title"><span>Title</span></label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="title" required>
                </div>
                <br>
                <div class="profile-info">
                    <label for="subtitle"><span>Subtitle</span></label>
                    <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="subtitle" required>
                </div>
                <br>
                <div class="profile-info">
                    <label for="content"><span>Content</span></label>
                    <textarea class="form-control" id="content" name="content" rows="10" placeholder="content" required></textarea>
                </div>
                <br>
                <div class="profile-info">
                    <label for="tag-create-article-input"><span>Tags</span></label>
                    <input type="text" id="tag-create-article-input" placeholder="Type to search tags...">
                    <div id="tag-create-article-suggestions" class="suggestions"></div>
                </div>
                <div id="selected-create-article-tags" class="selected"></div>
                <div class="profile-info">
                    <label for="content"><span>Topics</span></label>
                    <select class="form-control" id="topics" name="topics[]" required>
                        <option value="No_Topic" selected>No Topic</option>
                        <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($topic->id); ?>"><?php echo e($topic->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <br>
                <div class="profile-info">
                    <label for="article_picture"><span>Upload Article Picture</span></label>
                    <input type="file" name="article_picture" id="article_picture">
                </div>
                <?php if($errors->has('article_picture')): ?>
                    <br>
                    <div class="profile-info">
                        <span class="error">
                            <?php echo e($errors->first('article_picture')); ?>

                        </span>
                    </div>
                <?php endif; ?>
                <br>
                <br>
                <br>
                <div class="profile-info">
                    <span>Save your article before leaving: </span>
                    <button type="submit" class="large-rectangle small-text greyer">Submit</button>
                </div>
                <br>
            </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.homepage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/create_article.blade.php ENDPATH**/ ?>