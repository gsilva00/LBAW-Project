@foreach ($tagsPaginated as $tag)
    @include('partials.tag_tile', ['tag' => $tag])
@endforeach