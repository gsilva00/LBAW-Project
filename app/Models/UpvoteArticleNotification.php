<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UpvoteArticleNotification extends Model
{
    use HasFactory;

    protected $table = 'upvote_article_notification';

    protected $fillable = [
        'ntf_id',
        'article_id',
    ];

    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class, 'ntf_id');
    }
}