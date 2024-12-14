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
        'id',
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

    public function getSenderDisplayNameAttribute(): array
    {
        return $this->sender ? [$this->sender->display_name, $this->sender->username] : ['Unknown', 'Unknown'];
    }

    public function getRecipientDisplayNameAttribute(): array
    {
        return $this->recipient ? [$this->recipient->display_name, $this->recipient->username] : ['Unknown', 'Unknown'];
    }


    // Querying
    // Get respective subclass entry for a base class entry
    public function getSpecificNotification(): array|null
    {
        $ntfTypes = [
            1 => CommentNotification::class,
            2 => ReplyNotification::class,
            3 => UpvoteArticleNotification::class,
            4 => UpvoteCommentNotification::class,
            5 => UpvoteReplyNotification::class
        ];

        foreach ($ntfTypes as $type => $class) {
            $equivSubEntry = $this->hasOne($class, 'ntf_id')->first();
            if ($equivSubEntry) {
                return [$type, $equivSubEntry];
            }
        }

    }

    public static function getArquivedNotificationsForUser(User $user)
    {
        return $user->notificationsReceived()->where('is_viewed', true)->get();
    }

    public static function getNewNotificationsForUser(User $user)
    {
        return $user->notificationsReceived()->where('is_viewed', false)->get();
    }

    public static function getNotificationsForUserByType(User $user, int $type, bool $isViewed)
    {
        if($isViewed){
            $notifications = $user->notificationsReceived()->where('is_viewed', true)->get();
        }
        else{
            $notifications = $user->notificationsReceived()->where('is_viewed', false)->get();
        }
        $newNotifications = [];

        foreach ($notifications as $notification) {
            $specificNotification = $notification->getSpecificNotification();
            if ($type === 1) {
                if ($specificNotification[0] === 1 || $specificNotification[0] === 2) {
                    $newNotifications[] = $notification;
                }
            } else {
                if ($specificNotification[0] === 3 || $specificNotification[0] === 4 || $specificNotification[0] === 5) {
                    $newNotifications[] = $notification;
                }
            }
        }

        return $newNotifications;
    }


}