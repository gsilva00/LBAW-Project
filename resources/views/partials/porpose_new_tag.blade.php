<div id="popup" class="popup" style="display: none;">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="popup-content">
        <button id="close-popup" class="close-button">&times;</button>
        <form id="popup-form" action="#" method="POST">
            <label for="popup-input">Enter your purposed tag:</label>
            <input type="text" id="popup-input" name="popup-input" required>
            <button type="submit" id="submitTagButton" data-action-url="{{ route('proposeTagSubmit') }}">Submit</button>        </form>
    </div>
</div>