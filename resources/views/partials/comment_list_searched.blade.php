@if($commentsItems->isEmpty())
    <p>No Comments/Replies found.</p>
@else
    @foreach($commentsItems as $comment)
        @include('partials.comment_searched', ['comment' => $comment, 'user' => $user, 'isReply' => $isReplies])
    @endforeach
@endif