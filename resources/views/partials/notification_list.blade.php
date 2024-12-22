@php
if (!($notifications instanceof \Illuminate\Support\Collection)) {
        $notifications = collect($notifications);
    }
@endphp

@if($notifications->isEmpty())
    <div class="not-available-container">                    
        <p>No notifications available.</p>
    </div>
@else
    @foreach($notifications as $notification)
        @include('partials.notification_card', ['comment' => $notification])
    @endforeach
@endif