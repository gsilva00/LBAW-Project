@foreach($notifications as $notification)
    @include('partials.notification_card', ['comment' => $notification])
@endforeach
