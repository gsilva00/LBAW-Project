<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReplyNotification extends Model
{
    use HasFactory;

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