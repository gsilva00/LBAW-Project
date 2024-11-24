@foreach ($users as $user)
    @include('partials.user_tile', ['user' => $user])
@endforeach