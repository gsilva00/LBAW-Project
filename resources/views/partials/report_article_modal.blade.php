<div id="reportArticlePopup" class="popup" @if($state === 'reportComment' || $state === 'reportReply') data-is-reply="{{$state === "reportComment" ? "false" : "true"}}"@endif>
    <div class="popup-content">
        <span class="remove" onclick="closePopup()">&times;</span>
        @if($state === 'reportArticle')
            <h2>Report Article</h2>
        @elseif($state === 'reportComment' || $state === 'reportReply')
            <h2>Report Comment</h2>
        @else
            <h2>Report User</h2>
        @endif
        <section>
            <label for="reportReason" class="h2">Reason for Reporting</label>
            <textarea class="form-control" id="reportReason" rows="3" maxlength="300" required></textarea>
            <span id="charCountFeedback" class="small-text">0/300 characters</span>
        </section>
        <section>
            <label for="reportCategory" class="h2">Category</label>
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
        </section>
        @if($state === 'reportArticle')
            <button type="button" id="submitReportButton" class="large-rectangle" data-action-url="{{ route('reportArticleSubmit', ['id' => $articleId]) }}">Submit Report</button>
        @endif
        @if($state === 'reportComment' || $state === 'reportReply')
            <button type="button" id="submitReportButton" class="large-rectangle" data-action-url="{{ route('reportCommentSubmit', ['id' => $commentId]) }}">Submit Report</button>
        @endif
        @if($state === 'reportUser')
            <button type="button" id="submitReportButton" class="large-rectangle" data-action-url="{{ route('reportUserSubmit', ['id' => $userId]) }}">Submit Report</button>
        @endif
    </div>
</div>