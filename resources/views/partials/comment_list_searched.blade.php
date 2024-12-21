@if($commentsItems->isEmpty())
    <br>
    <div class="not-available-container">
    <p>No Comments/Replies found.</p>
    </div>
@else
    @foreach($commentsItems as $comment)
        @include('partials.comment_searched', ['comment' => $comment, 'user' => $user, 'isReply' => $isReplies])
    @endforeach
@endif