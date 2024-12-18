<form id="comment-form" class="comment" method="POST" action="{{ route('writeComment', ['id' => $article->id]) }}">
    @csrf
    @if(Auth::guest() || $user->is_deleted)
        <img src="{{ asset('images/profile/default.jpg') }}" alt="Your profile picture">
    @else
        <img src="{{ asset('images/profile/' . $user->profile_picture) }}" alt="Your profile picture">
    @endif
    <div class="comment-input-container">
        @if($state == "editComment")
            <input type="text" class="comment-input" name="comment" value="{{ $comment->content }}" @if(Auth::guest() || $user->is_deleted) disabled @endif>
        @else
            <input type="text" class="comment-input" name="comment" placeholder="Write a comment..." @if(Auth::guest() || $user->is_deleted) disabled @endif>
        @endif

        <button class="small-rectangle" title="Send comment" @if(Auth::guest() || $user->is_deleted) disabled @endif><i class='bx bx-send remove-position'></i><span>Send</span></button>
    </div>
</form>