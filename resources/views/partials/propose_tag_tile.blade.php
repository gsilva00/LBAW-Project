<div class="notification-card">
    <div class="profile-info appeal-wrapper">
    <p>{{ $tagProposal->name }}</p>
    <form class="accept-proposal-form" method="POST" action="{{ route('acceptTagProposal', ['id' => $tagProposal->id]) }}">
        @csrf
        <button type="submit" class="large-rectangle small-text greener">Accept</button>
    </form>
    <form class="reject-proposal-form" method="POST" action="{{ route('rejectTagProposal', ['id' => $tagProposal->id]) }}">
        @csrf
        <button type="submit" class="large-rectangle small-text red-button">Reject</button>
    </form>
    </div>
</div>