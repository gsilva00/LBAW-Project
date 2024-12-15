<div class="notification-card" notification_id="{{ $notification->id }}">
    @php
        $pair_users = [$notification->getRecipientDisplayNameAttribute(), $notification->getSenderDisplayNameAttribute()];
        $notification_specifics = $notification->getSpecificNotification();
    @endphp

    <p><strong>Date:</strong> {{ $notification->ntf_date }}</p>
    <p><strong>Viewed:</strong> {{ $notification->is_viewed ? 'Yes' : 'No' }}</p>
    <p><strong>To:</strong> <a href="{{ route('profile', ['username' => $pair_users[0][1]]) }}">{{ $pair_users[0][0] }}</a></p>
    <p><strong>From:</strong> <a href="{{ route('profile', ['username' => $pair_users[1][1]]) }}">{{ $pair_users[1][0] }}</a></p>
    <p><strong>Notification type:</strong> {{ $notification_specifics[0] }}</p>
    <p><strong>ntf_id:</strong> {{ $notification_specifics[1]->ntf_id }}</p>

    @if($notification_specifics[0] === 1)
        <p><strong>comment_id:</strong> {{ $notification_specifics[1]->comment_id }}</p>
        <p><a href="#"><strong>View Comment</strong></a></p>
    @elseif($notification_specifics[0] === 2)
        <p><strong>reply_id:</strong> {{ $notification_specifics[1]->reply_id }}</p>
        <p><a href="#"><strong>View Reply</strong></a></p>
    @elseif($notification_specifics[0] === 3)
        <p><strong>article_id:</strong> {{ $notification_specifics[1]->article_id }}</p>
        <p><a href="{{ route('showArticle', ['id' => $notification_specifics[1]->article_id]) }}"><strong>View Article</strong></a></p>
    @elseif($notification_specifics[0] === 4)
        <p><strong>comment_id:</strong> {{ $notification_specifics[1]->comment_id }}</p>
        <p><a href="#"><strong>View Comment</strong></a></p>
    @elseif($notification_specifics[0] === 5)
        <p><strong>reply_id:</strong> {{ $notification_specifics[1]->reply_id }}</p>
        <p><a href="#"><strong>View Reply</strong></a></p>
    @endif

    @if(!$notification->is_viewed)
        <button type="submit" class="btn btn-primary archive-button" data-notification-id="{{ $notification->id }}" id="archive-button">Archive</button>
    @endif
</div>