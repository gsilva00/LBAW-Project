@if (session('success'))
    <div class="success">
        <span>
            {{ session('success') }}
        </span>
        <button type="button" id="close-message-button" onclick="closeMessage()">
            <i class='bx bx-x'></i>
        </button>
    </div>
@endif