<div id="reportNewsPopup" class="popup">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <h5>Report News</h5>
        <form id="reportNewsForm" action="{{ route('reportArticleSubmit', ['id' => $article->id]) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="reportReason" class="form-label">Reason for Reporting</label>
                <textarea class="form-control" id="reportReason" name="description" rows="3" maxlength="300" required></textarea>
                <div id="charCountFeedback">0/300 characters</div>
            </div>
            <div class="mb-3">
                <label for="reportCategory" class="form-label">Category</label>
                <select class="form-control" id="reportCategory" name="type" required>
                    <option value="Fact Check">Fact Check</option>
                    <option value="Harassment">Harassment</option>
                    <option value="Spam">Spam</option>
                    <option value="Violence or Sexual Content">Violence or Sexual Content</option>
                </select>
            </div>
            <button type="submit" class="btn">Submit Report</button>
        </form>
    </div>
</div>