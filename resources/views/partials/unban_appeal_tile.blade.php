<div class="unban-appeal-tile">
    <p>{{ $unbanAppeal->description }}</p>
    <form class="accept-appeal-form" method="POST" action="{{ route('acceptUnbanAppeal', ['id' => $unbanAppeal->id]) }}">
        @csrf
        <button type="submit" class="accept-appeal">Unban</button>
    </form>
    <form class="reject-appeal-form" method="POST" action="{{ route('rejectUnbanAppeal', ['id' => $unbanAppeal->id]) }}">
        @csrf
        <button type="submit" class="reject-appeal">Reject</button>
    </form>
</div>