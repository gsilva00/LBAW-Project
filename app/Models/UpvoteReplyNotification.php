<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UpvoteReplyNotification extends Model
{
    public $timestamps = false;

    protected $table = 'upvote_reply_notification';

    protected $fillable = [
        'ntf_id',
        'reply_id',
    ];


    // Relationships
    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class, 'ntf_id');
    }


    // Querying
    // ...

}