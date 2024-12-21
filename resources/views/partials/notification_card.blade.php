@php
    $user = Auth::user();
    $pair_users = [$notification->getRecipientDisplayNameAttribute(), $notification->getSenderDisplayNameAttribute()];
    $notification_specifics = $notification->getSpecificNotification();

    $first_condition = ($notification_specifics[0] === 3 || $notification_specifics[0] === 4 || $notification_specifics[0] === 5) && $user->upvote_notification;
    $second_condition = ($notification_specifics[0] === 1 || $notification_specifics[0] === 2) && $user->comment_notification;
@endphp
@if($first_condition || $second_condition)
    @if($notification->is_viewed)
        <div class="notification-card greyer" notification_id="{{ $notification->id }}">
    @else
        <div class="notification-card" notification_id="{{ $notification->id }}">
    @endif
        @if($notification_specifics[0] === 1)
            <div class="profile-info">
            <p><i class='bx bx-comment'></i>
            @if($pair_users[1][0] === $user->display_name)
                <a href="{{ route('profile', ['username' => $pair_users[1][1]]) }}">You</a>
            @else
                <a href="{{ route('profile', ['username' => $pair_users[1][1]]) }}">{{ $pair_users[1][0] }}</a>
            @endif
             commented on your article</p>
        
             <button type="button" class="small-rectangle" onclick="window.location.href='{{ route('showArticle', ['id' => $notification_specifics[1]->comment->article_id]) }}'">
                <i class='bx bx-show remove-position' ></i>
                View Comment
            </button> 
        @elseif($notification_specifics[0] === 2)
            <div class="profile-info">
            <p><i class='bx bx-comment'></i>
            @if($pair_users[1][0] === $user->display_name)
                <a href="{{ route('profile', ['username' => $pair_users[1][1]]) }}">You</a>
            @else
                <a href="{{ route('profile', ['username' => $pair_users[1][1]]) }}">{{ $pair_users[1][0] }}</a>
            @endif
             replied "{{$notification_specifics[1]->reply->content}}" on the comment "{{$notification_specifics[1]->reply->comment->content}}" from your article</p>
            
             <button type="button" class="small-rectangle" onclick="window.location.href='{{ route('showArticle', ['id' => $notification_specifics[1]->reply->comment->article_id]) }}'">
                <i class='bx bx-show remove-position' ></i>
                View Reply
            </button>      
        @elseif($notification_specifics[0] === 3)
            <div class="profile-info">
            <p><i class='bx bx-comment'></i>
            @if($pair_users[1][0] === $user->display_name)
                <a href="{{ route('profile', ['username' => $pair_users[1][1]]) }}">You</a>
            @else
                <a href="{{ route('profile', ['username' => $pair_users[1][1]]) }}">{{ $pair_users[1][0] }}</a>
            @endif
             upvoted on your article</p>
            
             <button  type="button" class="small-rectangle" onclick="window.location.href='{{ route('showArticle', ['id' => $notification_specifics[1]->article_id]) }}'">
                <i class='bx bx-show remove-position' ></i>
                View Comment
            </button>       
        @elseif($notification_specifics[0] === 4)
            <div class="profile-info">
            <p><i class='bx bx-comment'></i>
            @if($pair_users[1][0] === $user->display_name)
                <a href="{{ route('profile', ['username' => $pair_users[1][1]]) }}">You</a>
            @else
                <a href="{{ route('profile', ['username' => $pair_users[1][1]]) }}">{{ $pair_users[1][0] }}</a>
            @endif
             upvoted on the comment "{{$notification_specifics[1]->comment->content}}" from your article</p>
            
             <button type="button" class="small-rectangle" onclick="window.location.href='{{ route('showArticle', ['id' => $notification_specifics[1]->comment->article_id]) }}'">
                <i class='bx bx-show remove-position' ></i>
                View Comment
            </button>    
        @elseif($notification_specifics[0] === 5)
            <div class="profile-info">
            <p><i class='bx bx-comment'></i>
            @if($pair_users[1][0] === $user->display_name)
                <a href="{{ route('profile', ['username' => $pair_users[1][1]]) }}">You</a>
            @else
                <a href="{{ route('profile', ['username' => $pair_users[1][1]]) }}">{{ $pair_users[1][0] }}</a>
            @endif
             upvoted on the reply "{{$notification_specifics[1]->comment->content}}" from your article</p>
            
            <button type="button" class="small-rectangle" onclick="window.location.href='{{ route('showArticle', ['id' => $notification_specifics[1]->reply->comment->article_id]) }}'">
                <i class='bx bx-show remove-position' ></i>
                View Reply
            </button>
        @endif

        @if(!$notification->is_viewed)
            <button type="button" class="small-rectangle" data-notification-id="{{ $notification->id }}" id="archive-button">
                <i class='bx bx-archive-in remove-position'></i>Archive
            </button>
        @endif
        </div>
        <p class="small-text date">{{ $notification->ntf_date }}</p>
    </div>
@endif