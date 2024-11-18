<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ArticlePage extends Model
{
    use HasFactory;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'edit_date';

    protected $table = 'articlepage';
    protected $fillable = [
        'title',
        'subtitle',
        'content',
        'article_image',
        'upvotes',
        'downvotes',
        'is_edited',
        'is_deleted',
        'topic_id',
        'author_id',
    ];
    protected $attributes = [
        'edit_date' => null,
        'article_image' => null,
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

    public function topic(): BelongsTo
    {
        return $this->belongsTo(
            Topic::class,
            'topic_id'
        );
    }
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            'ArticleTag',
            'article_id',
            'tag_id'
        );
    }

    public function comments(): HasMany
    {
        return $this->hasMany(
            Comment::class,
            'article_id'
        );
    }

    public function voters(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'VoteArticle',
            'article_id',
            'user_id'
        )->withPivot('type');
    }
    public function favouriters(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'FavouriteArticle',
            'article_id',
            'user_id'
        );
    }
    public function voteDetails(): HasMany
    {
        return $this->hasMany(
            VoteArticle::class,
            'article_id'
        );
    }


    public function reportsReceived(): HasMany
    {
        return $this->hasMany(
            ReportArticle::class,
            'article_id'
        );
    }

    public function upvoteNotifications(): HasManyThrough
    {
        return $this->hasManyThrough(
            UpvoteArticleNotification::class,
            Notifications::class,
            'article_id',
            'ntf_id',
            'id',
            'id'
        );
    }
}
