<div class="notification-card">
    <div class="profile-info appeal-wrapper">
    <p>{{ $unbanAppeal->description }}</p>
    <form method="POST" action="{{ route('acceptUnbanAppeal', ['id' => $unbanAppeal->id]) }}">
        @csrf
        <button type="submit" class="large-rectangle small-text greener">Unban</button>
    </form>
    <form method="POST" action="{{ route('rejectUnbanAppeal', ['id' => $unbanAppeal->id]) }}">
        @csrf
        <button type="submit" class="large-rectangle small-text red-button">Reject</button>
    </form>
    </div>
</div>