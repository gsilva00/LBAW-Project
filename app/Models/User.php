<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false; // Don't add create and update timestamps in database.
    // protected $table = 'users'; - This is default Laravel conversion (lowercase camel_case model name)

    // The attributes that are mass assignable.
    protected $fillable = [
        'display_name',
        'username',
        'email',
        'password',
        'profile_picture',
        'description',
        'upvote_notification',
        'comment_notification',
    ];

    // The model's default values for attributes.
    protected $attributes = [
        'display_name' => null,
        'profile_picture' => null,
        'description' => null,
        'reputation' => 3,
        'upvote_notification' => true,
        'comment_notification' => true,
        'is_banned' => false,
        'is_admin' => false,
        'is_fact_checker' => false,
        'is_deleted' => false,
        'remember_token' => null,
    ];

    // The attributes that should be hidden for serialization to an array or JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // The attributes that should be cast when setting values and getting them from the database
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function ownedArticles(): HasMany
    {
        return $this->hasMany(
            ArticlePage::class,
            'author_id'
        );
    }
    public function ownedComments(): HasMany
    {
        return $this->hasMany(
            Comment::class,
            'author_id'
        );
    }
    public function ownedReplies(): HasMany
    {
        return $this->hasMany(
            Reply::class,
            'author_id'
        );
    }


    public function followedTopics(): BelongsToMany
    {
        return $this->belongsToMany(
            Topic::class,
            'FollowTopic',
            'user_id',
            'topic_id'
        );
    }
    public function followedTags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            'FollowTag',
            'user_id',
            'tag_id'
        );
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'FollowUser',
            'following_id',
            'follower_id'
        );
    }
    public function following(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'FollowUser',
            'follower_id',
            'following_id'
        );
    }

    // Votes and favorites
    public function votedArticles(): BelongsToMany
    {
        return $this->belongsToMany(
            ArticlePage::class,
            'VoteArticle',
            'user_id',
            'article_id'
        )->withPivot('type');
    }
    public function votedComments(): BelongsToMany
    {
        return $this->belongsToMany(
            Comment::class,
            'VoteComment',
            'user_id',
            'comment_id'
        )->withPivot('type');
    }
    public function votedReplies(): BelongsToMany
    {
        return $this->belongsToMany(
            Reply::class,
            'VoteReply',
            'user_id',
            'reply_id'
        )->withPivot('type');
    }

    public function favouriteArticles(): BelongsToMany
    {
        return $this->belongsToMany(
            ArticlePage::class,
            'FavouriteArticle',
            'user_id',
            'article_id'
        );
    }

    // Reports
    public function reportsSent(): HasMany
    {
        return $this->hasMany(
            Report::class,
            'reporter_id'
        );
    }

    // Proposals, Appeals and Requests
    public function tagProposals(): HasMany
    {
        return $this->hasMany(
            ProposeNewTag::class
        );
    }
    public function unbanAppeals(): HasMany
    {
        return $this->hasMany(
            AppealToUnban::class
        );
    }
    public function factCheckerRequests(): HasMany
    {
        return $this->hasMany(
            AskToBecomeFactChecker::class
        );
    }

    // Notifications
    public function notificationsReceived(): HasMany
    {
        return $this->hasMany(
            Notifications::class,
            'user_to'
        );
    }
    public function notificationsSent(): HasMany
    {
        return $this->hasMany(
            Notifications::class,
            'user_from'
        );
    }
}