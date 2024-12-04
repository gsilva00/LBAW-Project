<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    protected $attributes = [
        'is_viewed' => false,
    ];


    // Relationships
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_from');
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_to');
    }


    // Querying
    // Get respective subclass entry for a base class entry
    public function getSpecificNotification(): HasOne|null
    {
        $ntfTypes = [
            CommentNotification::class,
            ReplyNotification::class,
            UpvoteArticleNotification::class,
            UpvoteCommentNotification::class,
            UpvoteReplyNotification::class
        ];

        foreach ($ntfTypes as $type) {
            $equivSubEntry = $this->hasOne($type, 'ntf_id')->first();
            if ($equivSubEntry) {
                return $equivSubEntry;
            }
        }

        return null;
    }

}