<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReplyNotification extends Model
{
    public $timestamps = false;

    protected $table = 'reply_notification';

    protected $fillable = [
        'ntf_id',
        'reply_id',
    ];


    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class, 'ntf_id');
    }
}