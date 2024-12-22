

<?php $__env->startSection('title', 'Admin Panel'); ?>

<?php $__env->startSection('content'); ?>
    <div class="recent-news-wrapper">
        <h1 class="large-rectangle">Administrator Panel</h1>
        <h2 class="large-rectangle ligth-green">List of User Accounts</h2>
        <div id="users-section">
            <?php if(!$usersPaginated->isEmpty()): ?>
                <div id="user-list">
                    <?php echo $__env->make('partials.user_tile_list', ['users' => $usersPaginated, 'isAdminPanel' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <button id="load-more-users"
                        class="large-rectangle small-text greener"
                        data-entity="user"
                        data-page-num="<?php echo e($userCurrPageNum+1); ?>"
                        data-url="<?php echo e(route('moreUsers')); ?>"
                        <?php if(!$userHasMorePages): ?>
                            style="display: none"
                        <?php else: ?>
                            style="display: block"
                        <?php endif; ?>
                >
                    Load More
                </button>
            <?php else: ?>
                <div class="not-available-container">
                    <p>No user accounts to list.</p>
                </div>
            <?php endif; ?>
        </div>
        <h2 class="large-rectangle ligth-green">Create New User</h2>
        <div id="user-form-section">
            <?php echo $__env->make('partials.create_user_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <br>
        <br>
        <h2 class="large-rectangle ligth-green">List of Topics</h2>
        <div id="topics-section">
            <?php if(!$topicsPaginated->isEmpty()): ?>
                <div id="topic-list" class="profile-info">
                    <?php echo $__env->make('partials.topic_tile_list', ['topics' => $topicsPaginated], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <button id="load-more-topics"
                        class="large-rectangle small-text greener"
                        data-entity="topic"
                        data-page-num="<?php echo e($topicCurrPageNum+1); ?>"
                        data-url="<?php echo e(route('moreTopics')); ?>"
                        <?php if(!$topicHasMorePages): ?>
                            style="display: none"
                        <?php else: ?>
                            style="display: block"
                        <?php endif; ?>
                >
                    Load More
                </button>
            <?php else: ?>
                <div class="not-available-container">
                    <p>No topics exist to list.</p>
                </div>
            <?php endif; ?>
        </div>
        <h2 class="large-rectangle ligth-green">Create a New Topic</h2>
        <div id="topic-form-section">
            <?php echo $__env->make('partials.create_topic_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <br>
        <br>
        <h2 class="large-rectangle ligth-green">List of Tags</h2>
        <div id="tags-section">
            <?php if(!$tagsPaginated->isEmpty()): ?>
                <div id="tag-list">
                    <?php echo $__env->make('partials.tag_tile_list', ['tags' => $tagsPaginated], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <button id="load-more-tags"
                        class="large-rectangle small-text greener"
                        data-entity="tag"
                        data-page-num="<?php echo e($tagCurrPageNum+1); ?>"
                        data-url="<?php echo e(route('moreTags')); ?>"
                        <?php if(!$tagHasMorePages): ?>
                            style="display: none"
                        <?php else: ?>
                            style="display: block"
                        <?php endif; ?>
                >
                    Load More
                </button>
            <?php else: ?>
                <div class="not-available-container">
                    <p>No tags exist to list.</p>
                </div>
            <?php endif; ?>
        </div>
        <br>
        <br>
        <h2 class="large-rectangle ligth-green">Create a New Tag</h2>
        <div id="tag-form-section">
            <?php echo $__env->make('partials.create_tag_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <br>
        <br>
        <h2 class="large-rectangle ligth-green">List of Pending Tag Proposals</h2>
        <div id="tag-proposals-section">
            <?php if(!$tagProposalsPaginated->isEmpty()): ?>
                <div id="tag-proposal-list">
                    <?php echo $__env->make('partials.propose_tag_tile_list', ['tagProposalsPaginated' => $tagProposalsPaginated], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <button id="load-more-tag-proposals"
                        class="large-rectangle small-text greener"
                        data-entity="tag-proposal"
                        data-page-num="<?php echo e($tagProposalCurrPageNum+1); ?>"
                        data-url="<?php echo e(route('moreTagProposals')); ?>"
                        <?php if(!$tagProposalHasMorePages): ?>
                            style="display: none"
                        <?php else: ?>
                            style="display: block"
                        <?php endif; ?>
                >
                    Load More
                </button>
                <br>
                <br>
            <?php else: ?>
                <div class="not-available-container">
                    <p>No pending tag proposals to list.</p>
                </div>
            <?php endif; ?>
        </div>
        <h2 class="large-rectangle ligth-green">List of Pending Unban Appeals</h2>
        <div id="unban-appeals-section">
            <?php if(!$unbanAppealsPaginated->isEmpty()): ?>
                <div id="unban-appeal-list">
                    <?php echo $__env->make('partials.unban_appeal_tile_list', ['unbanAppealsPaginated' => $unbanAppealsPaginated], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <button id="load-more-unban-appeals"
                        class="large-rectangle small-text greener"
                        data-entity="unban-appeal"
                        data-page-num="<?php echo e($unbanAppealCurrPageNum+1); ?>"
                        data-url="<?php echo e(route('moreUnbanAppeals')); ?>"
                        <?php if(!$unbanAppealHasMorePages): ?>
                            style="display: none"
                        <?php else: ?>
                            style="display: block"
                        <?php endif; ?>
                >
                    Load More
                </button>
            <?php else: ?>
                <div class="not-available-container">
                    <p>No pending unban appeals to list.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/pages/admin_panel.blade.php ENDPATH**/ ?>