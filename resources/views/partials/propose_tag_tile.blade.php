<div class="propose-tag-tile">
    <p>{{ $tagProposal->name }}</p>
    <form class="accept-proposal-form" method="POST" action="{{ route('acceptTagProposal', ['id' => $tagProposal->id]) }}">
        @csrf
        <button type="submit" class="accept-proposal">Accept</button>
    </form>
    <form class="reject-proposal-form" method="POST" action="{{ route('rejectTagProposal', ['id' => $tagProposal->id]) }}">
        @csrf
        <button type="submit" class="reject-proposal">Reject</button>
    </form>
</div>