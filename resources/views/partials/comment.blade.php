<div class="comment">
    <p><strong>{{ $comment->author->display_name }}:</strong> {{ $comment->content }}</p>
    <p><strong>Date:</strong> {{ $comment->cmt_date }}</p>
    <p><strong>Upvotes:</strong> {{ $comment->upvotes }} <strong>Downvotes:</strong> {{ $comment->downvotes }}</p>
    <p><strong>Edited:</strong> {{ $comment->is_edited ? 'Yes' : 'No' }}</p>
</div>