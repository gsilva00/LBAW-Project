<div class="error-pop-up">
    <i class='bx bx-error-circle'></i>
    <span class="error">
        @if($errors->any())
            {{ $errors->first() }}
        @endif
    </span>
    <button type="button" id="close-message-button" onclick="closeMessage()">
        <i class='bx bx-x'></i>
    </button>
</div>