<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UpvoteCommentNotification extends Notification
{
    public $timestamps = false;

    protected $table = 'upvote_comment_notification';

    protected $fillable = [
        'ntf_id',
        'comment_id',
    ];

    // Override default values (since there are none) of the base class/model/table
    protected $attributes = [];

    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class, 'ntf_id');
    }
}