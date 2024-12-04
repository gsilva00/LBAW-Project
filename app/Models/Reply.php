<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reply extends Model
{
    use HasFactory;

    const CREATED_AT = 'rpl_date';
    const UPDATED_AT = null;

    protected $table = 'reply';

    protected $fillable = [
        'content',
        'upvotes',
        'downvotes',
        'is_edited',
        'is_deleted',
        'author_id',
        'comment_id',
    ];
    protected $attributes = [
        'upvotes' => 0,
        'downvotes' => 0,
        'is_edited' => false,
        'is_deleted' => false,
    ];


    // Relationships
    public function author(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'author_id'
        );
    }

    public function comment(): BelongsTo
    {
        return $this->belongsTo(
            Comment::class,
            'comment_id'
        );
    }

    public function reportsReceived(): HasMany
    {
        return $this->hasMany(
            ReportComment::class,
            'reply_id'
        );
    }

    public function voters(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'vote_reply',
            'reply_id',
            'user_id'
        )->withPivot('type');
    }


    // Querying
    // ...

    public function isUpvotedBy(User $user): bool
    {
        return $this->voters()->wherePivot('type', 'Upvote')->where('user_id', $user->id)->exists();
    }

    public function isDownvotedBy(User $user): bool
    {
        return $this->voters()->wherePivot('type', 'Downvote')->where('user_id', $user->id)->exists();
    }


}
