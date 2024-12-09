<div id="reportArticlePopup" class="popup" @if($state === 'reportComment' || $state === 'reportReply') data-is-reply="{{$state === "reportComment" ? "false" : "true"}}"@endif>
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
            @if($state === 'reportArticle')
                <select class="form-control" id="reportCategory" required>
                    <option value="Fact Check">Fact Check</option>
                    <option value="Harassment">Harassment</option>
                    <option value="Spam">Spam</option>
                    <option value="Violence or Sexual Content">Violence or Sexual Content</option>
                </select>
            @endif
            @if($state === 'reportComment' || $state === 'reportReply')
                <select class="form-control" id="reportCategory" required>
                    <option value="Disinformation">Disinformation</option>
                    <option value="Harassment">Harassment</option>
                    <option value="Spam">Spam</option>
                    <option value="Violence or Sexual Content">Violence or Sexual Content</option>
                </select>
            @endif
            @if($state === 'reportUser')
                <select class="form-control" id="reportCategory" required>
                    <option value="Disinformation">Disinformation</option>
                    <option value="Harassment">Harassment</option>
                    <option value="Spam">Spam</option>
                    <option value="Violence or Sexual Content">Violence or Sexual Content</option>
                    <option value="Impersonation">Impersonation</option>
                </select>
            @endif
        </div>
        @if($state === 'reportArticle')
            <button type="button" id="submitReportButton" class="btn" data-action-url="{{ route('reportArticleSubmit', ['id' => $articleId]) }}">Submit Report</button>
        @endif
        @if($state === 'reportComment' || $state === 'reportReply')
            <button type="button" id="submitReportButton" class="btn" data-action-url="{{ route('reportCommentSubmit', ['id' => $commentId]) }}">Submit Report</button>
        @endif
        @if($state === 'reportUser')
            <button type="button" id="submitReportButton" class="btn" data-action-url="{{ route('reportUserSubmit', ['id' => $userId]) }}">Submit Report</button>
        @endif
    </div>
</div>