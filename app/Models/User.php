<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false; // Don't add create and update timestamps in database.

    protected $table = 'users'; // This is default Laravel conversion (lowercase camel_case model name)

    // The attributes that are mass assignable.
    protected $fillable = [
        'display_name',
        'username',
        'email',
        'password',
        'profile_picture',
        'description',
        'reputation',
        'upvote_notification',
        'comment_notification',
    ];

    // The model's default values for attributes.
    protected $attributes = [
        'display_name' => null,
        'profile_picture' => 'default.jpg',
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
        'is_banned',
        'is_admin',
        'is_fact_checker',
        'is_deleted',
        'remember_token',
    ];

    // The attributes that should be cast when setting values and getting them from the database
    protected $casts = [
        'password' => 'hashed',
        'reputation' => 'integer',
        'upvote_notification' => 'boolean',
        'comment_notification' => 'boolean',
        'is_banned' => 'boolean',
        'is_admin' => 'boolean',
        'is_fact_checker' => 'boolean',
        'is_deleted' => 'boolean',
    ];


    // Relationships
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

    // - Follows
    public function followedTopics(): BelongsToMany
    {
        return $this->belongsToMany(
            Topic::class,
            'follow_topics',
            'user_id',
            'topic_id'
        );
    }

    public function followedTags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            'follow_tags',
            'user_id',
            'tag_id'
        );
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'follow_user',
            'following_id',
            'follower_id'
        );
    }
    public function following(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'follow_user',
            'follower_id',
            'following_id'
        );
    }

    // - Votes and favourites
    public function votedArticles(): BelongsToMany
    {
        return $this->belongsToMany(
            ArticlePage::class,
            'vote_article',
            'user_id',
            'article_id'
        )->withPivot('type');
    }
    public function votedComments(): BelongsToMany
    {
        return $this->belongsToMany(
            Comment::class,
            'vote_comment',
            'user_id',
            'comment_id'
        )->withPivot('type');
    }
    public function votedReplies(): BelongsToMany
    {
        return $this->belongsToMany(
            Reply::class,
            'vote_reply',
            'user_id',
            'reply_id'
        )->withPivot('type');
    }

    public function favouriteArticles(): BelongsToMany
    {
        return $this->belongsToMany(
            ArticlePage::class,
            'favourite_article',
            'user_id',
            'article_id'
        );
    }

    // - Reports
    public function reportsSent(): HasMany
    {
        return $this->hasMany(
            Report::class,
            'reporter_id'
        );
    }

    // - Proposals, Appeals and Requests
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

    // - Notifications
    public function notificationsReceived(): HasMany
    {
        return $this->hasMany(
            Notification::class,
            'user_to'
        );
    }
    public function notificationsSent(): HasMany
    {
        return $this->hasMany(
            Notification::class,
            'user_from'
        );
    }


    // Querying
    public static function find(string $username): ?self
    {
        $user = self::where('username', $username)->first();
        if (!$user) {
            throw new ModelNotFoundException("User not found");
        }
        return $user;
    }

    public function hasFollowedTopic($topic) {
        return $this->followedTopics->contains($topic);
    }

    public function hasFollowedTag($tag) {
        return $this->followedTags->contains($tag);
    }

    public function isFollowing($user) {
        return $this->following->contains($user);
    }

    public static function filterByFollowingUsers($users)
    {
        return ArticlePage::whereIn('author_id', $users->pluck('id'))->get();
    }

    public function getVoteTypeOnArticle(ArticlePage $article): int
    {
        $vote = $this->votedArticles()->where('article_id', $article->id)->first();
        if ($vote) {
            return $vote->pivot->type === 'Upvote' ? 1 : -1;
        }
        return 0;
    }

    public function isFavouriteArticle(ArticlePage $article): bool
    {
        return $this->favouriteArticles()->where('article_id', $article->id)->exists();
    }

    public function getFollowedTags()
    {
        return $this->followedTags()->get();
    }

    public function isFollowingUser(int $userId): bool
    {
        return $this->following()->where('following_id', $userId)->exists();
    }

    public static function filterBySearchQuery($searchQuery)
    {
        if (empty($searchQuery)) {
            return self::where('is_deleted', false)->get();
        } elseif (preg_match('/^".*"$/', $searchQuery)) {
            $exactQuery = trim($searchQuery, '"');
            return self::where('is_deleted', false)
                ->where(function($query) use ($exactQuery) {
                    $query->where('display_name', 'ILIKE', '% ' . $exactQuery)
                        ->orWhere('display_name', 'ILIKE', $exactQuery . ' %')
                        ->orWhere('display_name', 'ILIKE', '% ' . $exactQuery . ' %')
                        ->orWhere('display_name', 'ILIKE', $exactQuery);
                })
                ->get();
        } else {
            $words = explode(' ', $searchQuery);
            $sanitizedWords = array_map(function($word) {
                return $word . ':*';
            }, $words);
            $tsQuery = implode(' & ', $sanitizedWords);

            return self::where('is_deleted', false)
                ->whereRaw("display_name_tsv @@ to_tsquery(?)", [$tsQuery])
                ->orWhere(function($query) use ($words) {
                    foreach ($words as $word) {
                        $query->orWhere('display_name', 'ILIKE', '%' . $word . '%');
                    }
                })
                ->orderByRaw("ts_rank(display_name_tsv, to_tsquery(?)) DESC", [$tsQuery])
                ->get();
        }
    }

    //TRAN01
    public function deleteUserTransaction($userId)
    {
        DB::transaction(function () use ($userId) {
            DB::table('users')
                ->where('id', $userId)
                ->update([
                    'display_name' => null,
                    'username' => '!deleted!' . $userId,
                    'email' => '!deleted!' . $userId,
                    'password' => 'deleted',
                    'profile_picture' => 'default.jpg',
                    'description' => null,
                    'reputation' => null,
                    'upvote_notification' => false,
                    'comment_notification' => false,
                    'is_banned' => false,
                    'is_deleted' => true,
                    'is_admin' => false,
                    'is_fact_checker' => false
                ]);
        }, 5);
    }

}