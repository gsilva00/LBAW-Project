<div class="pop-up">
    <i class='bx bx-error-circle'></i>
    <span class="error">
        {{ $errors->first($field) }}
    </span>
    <button type="button" id="close-message-button" onclick="closeMessage()">
        <i class='bx bx-x'></i>
    </button>
</div>