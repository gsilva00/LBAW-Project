@foreach ($topicsPaginated as $topic)
    @include('partials.topic_tile', ['topic' => $topic])
@endforeach