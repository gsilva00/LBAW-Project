<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    public $timestamps = false;
    const CREATED_AT = 'cmt_date';

    protected $table = 'comment';

    protected $fillable = [
        'content',
        'upvotes',
        'downvotes',
        'is_edited',
        'is_deleted',
        'author_id',
        'article_id',
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

    public function voters(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'vote_comment',
            'comment_id',
            'user_id'
        )->withPivot('type');
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(
            ArticlePage::class,
            'article_id'
        );
    }

    public function replies(): HasMany
    {
        return $this->hasMany(
            Reply::class,
            'comment_id'
        );
    }
}
