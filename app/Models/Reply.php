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

    public $timestamps = false; // No `updated_at` column.
    const CREATED_AT = 'rpl_date';

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

}
