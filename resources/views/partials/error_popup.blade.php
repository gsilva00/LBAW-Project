<div class="pop-up">
    <i class='bx bx-error-circle'></i>
    <span class="error">
        @if(isset($field) && $errors->has($field))
            {{ $errors->first($field) }}
        @elseif(session('error'))
            {{ session('error') }}
        @endif
    </span>
    <button type="button" id="close-message-button" onclick="closeMessage()">
        <i class='bx bx-x'></i>
    </button>
</div>