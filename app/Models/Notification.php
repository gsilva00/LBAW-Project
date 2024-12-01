<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    use HasFactory;

    const CREATED_AT = 'ntf_date';
    const UPDATED_AT = null;

    protected $table = 'notifications';

    protected $fillable = [
        'ntf_date',
        'is_viewed',
        'user_to',
        'user_from',
    ];

    /**
     * Get the user that sent the notification.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_from');
    }

    /**
     * Get the user that received the notification.
     */
    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_to');
    }

}