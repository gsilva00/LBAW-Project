<div id="reportArticlePopup" class="popup" <?php if($state === 'reportComment' || $state === 'reportReply'): ?> data-is-reply="<?php echo e($state === "reportComment" ? "false" : "true"); ?>"<?php endif; ?>>
    <div class="popup-content">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <h5>Report News</h5>
        <div class="mb-3">
            <label for="reportReason" class="form-label">Reason for Reporting</label>
            <textarea class="form-control" id="reportReason" rows="3" maxlength="300" required></textarea>
            <div id="charCountFeedback">0/300 characters</div>
        </div>
        <div class="mb-3">
            <label for="reportCategory" class="form-label">Category</label>
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
        </div>
        <?php if($state === 'reportArticle'): ?>
            <button type="button" id="submitReportButton" class="btn" data-action-url="<?php echo e(route('reportArticleSubmit', ['id' => $articleId])); ?>">Submit Report</button>
        <?php endif; ?>
        <?php if($state === 'reportComment' || $state === 'reportReply'): ?>
            <button type="button" id="submitReportButton" class="btn" data-action-url="<?php echo e(route('reportCommentSubmit', ['id' => $commentId])); ?>">Submit Report</button>
        <?php endif; ?>
        <?php if($state === 'reportUser'): ?>
            <button type="button" id="submitReportButton" class="btn" data-action-url="<?php echo e(route('reportUserSubmit', ['id' => $userId])); ?>">Submit Report</button>
        <?php endif; ?>
    </div>
</div><?php /**PATH C:\Users\Utiizador\Desktop\LBAW\lbaw24124\resources\views/partials/report_article_modal.blade.php ENDPATH**/ ?>