<div id="reportArticlePopup" class="popup" <?php if($state === 'reportComment' || $state === 'reportReply'): ?> data-is-reply="<?php echo e($state === "reportComment" ? "false" : "true"); ?>"<?php endif; ?>>
    <div class="popup-content">
        <span class="remove" onclick="closePopup()">&times;</span>
        <?php if($state === 'reportArticle'): ?>
            <h2>Report Article</h2>
        <?php elseif($state === 'reportComment' || $state === 'reportReply'): ?>
            <h2>Report Comment</h2>
        <?php else: ?>
            <h2>Report User</h2>
        <?php endif; ?>
        <section>
            <label for="reportReason" class="h2">Reason for Reporting</label>
            <textarea class="form-control" id="reportReason" rows="3" maxlength="300" required></textarea>
            <span id="charCountFeedback" class="small-text">0/300 characters</span>
        </section>
        <section>
            <label for="reportCategory" class="h2">Category</label>
            <?php if($state === 'reportArticle'): ?>
                <select class="form-control" id="reportCategory" required>
                    <option value="Fact Check">Fact Check</option>
                    <option value="Harassment">Harassment</option>
                    <option value="Spam">Spam</option>
                    <option value="Violence or Sexual Content">Violence or Sexual Content</option>
                </select>
            <?php endif; ?>
            <?php if($state === 'reportComment' || $state === 'reportReply'): ?>
                <select class="form-control" id="reportCategory" required>
                    <option value="Disinformation">Disinformation</option>
                    <option value="Harassment">Harassment</option>
                    <option value="Spam">Spam</option>
                    <option value="Violence or Sexual Content">Violence or Sexual Content</option>
                </select>
            <?php endif; ?>
            <?php if($state === 'reportUser'): ?>
                <select class="form-control" id="reportCategory" required>
                    <option value="Disinformation">Disinformation</option>
                    <option value="Harassment">Harassment</option>
                    <option value="Spam">Spam</option>
                    <option value="Violence or Sexual Content">Violence or Sexual Content</option>
                    <option value="Impersonation">Impersonation</option>
                </select>
            <?php endif; ?>
        </section>
        <?php if($state === 'reportArticle'): ?>
            <button type="button" id="submitReportButton" class="large-rectangle" data-action-url="<?php echo e(route('reportArticleSubmit', ['id' => $articleId])); ?>">Submit Report</button>
        <?php endif; ?>
        <?php if($state === 'reportComment' || $state === 'reportReply'): ?>
            <button type="button" id="submitReportButton" class="large-rectangle" data-action-url="<?php echo e(route('reportCommentSubmit', ['id' => $commentId])); ?>">Submit Report</button>
        <?php endif; ?>
        <?php if($state === 'reportUser'): ?>
            <button type="button" id="submitReportButton" class="large-rectangle" data-action-url="<?php echo e(route('reportUserSubmit', ['id' => $userId])); ?>">Submit Report</button>
        <?php endif; ?>
    </div>
</div><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/report_article_modal.blade.php ENDPATH**/ ?>