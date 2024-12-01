<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UpvoteCommentNotification extends Model
{
    use HasFactory;

    protected $table = 'upvote_comment_notification';

    protected $fillable = [
        'ntf_id',
        'comment_id',
    ];

    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class, 'ntf_id');
    }
}