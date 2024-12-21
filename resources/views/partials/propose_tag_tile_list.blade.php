@foreach($tagProposalsPaginated as $tp)
    @include('partials.propose_tag_tile', ['tagProposal' => $tp])
@endforeach