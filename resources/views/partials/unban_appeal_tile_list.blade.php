@foreach($unbanAppealsPaginated as $appeal)
    @include('partials.unban_appeal_tile', ['unbanAppeal' => $appeal])
@endforeach