<div id="appealUnbanPopup" class="popup">
    <div class="popup-content">
        <span id="closePopup" class="close-button">&times;</span>
        <h2>Appeal Unban</h2>
        <form id="appealUnbanForm">
            @csrf
            <label for="appealReason">Reason for Appeal:</label>
            <input type="text" id="appealReason" name="appealReason" required>
            <button type="submit" id="submirAppealUnban" data-action-url="{{ route('appealUnbanSubmit') }}">Submit</button>
        </form>
    </div>
</div>