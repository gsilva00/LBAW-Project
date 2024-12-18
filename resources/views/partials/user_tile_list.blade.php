@foreach ($usersPaginated as $user)
    @include('partials.user_tile', ['user' => $user])
@endforeach