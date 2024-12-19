<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\DB;

class ArticlePage extends Model
{
    use HasFactory;

    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'edit_date';

    protected $table = 'article_page';

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
        'create_date',
        'edit_date',
    ];
    protected $attributes = [
        'edit_date' => null,
        'article_image' => 'default.jpg',
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
            'article_tag',
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
            'vote_article',
            'article_id',
            'user_id'
        )->withPivot('type');
    }
    public function favouriters(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'favourite_article',
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
            Notification::class,
            'article_id',
            'ntf_id',
            'id',
            'id'
        );
    }


    // Querying
    public static function getMostRecentNews($how_many)
    {
        return self::where('is_deleted', false)
            ->orderBy('create_date', 'DESC')
            ->take($how_many)
            ->get();
    }

    public static function getAllRecentNews()
    {
        return self::where('is_deleted', false)
            ->orderBy('create_date', 'DESC')
            ->get();
    }

    public static function getArticlesByVotes()
    {
        return self::where('is_deleted', false)
            ->orderByRaw('(upvotes - downvotes) DESC')
            ->get();
    }

    public static function filterBySearchQuery($searchQuery)
    {
        if (empty($searchQuery)) {
            return self::where('is_deleted', false)->get();
        }
        elseif (preg_match('/^".*"$/', $searchQuery)) {
            $exactQuery = trim($searchQuery, '"');
            return self::where('is_deleted', false)
                ->where(function($query) use ($exactQuery) {
                    $query->Where('title', 'ILIKE', '% ' . $exactQuery)
                        ->orWhere('title', 'ILIKE', $exactQuery . ' %')
                        ->orwhere('title', 'ILIKE', '% ' . $exactQuery . ' %')
                        ->orWhere('title', 'ILIKE', $exactQuery)
                        ->orWhere('subtitle', 'ILIKE', '% ' . $exactQuery . ' %')
                        ->orWhere('subtitle', 'ILIKE', $exactQuery . ' %')
                        ->orWhere('subtitle', 'ILIKE', '% ' . $exactQuery)
                        ->orWhere('subtitle', 'ILIKE', $exactQuery)
                        ->orWhere('content', 'ILIKE', '% ' . $exactQuery . ' %')
                        ->orWhere('content', 'ILIKE', $exactQuery . ' %')
                        ->orWhere('content', 'ILIKE', '% ' . $exactQuery)
                        ->orWhere('content', 'ILIKE', $exactQuery);
                })
                ->get();
        }
        else {
            $words = explode(' ', $searchQuery);
            $sanitizedWords = array_map(function($word) {
                return $word . ':*';
            }, $words);
            $tsQuery = implode(' & ', $sanitizedWords);

            return self::where('is_deleted', false)
                ->whereRaw("tsv @@ to_tsquery(?)", [$tsQuery])
                ->orWhere(function($query) use ($words) {
                    foreach ($words as $word) {
                        $query->orWhere('title', 'ILIKE', '%' . $word . '%')
                            ->orWhere('subtitle', 'ILIKE', '%' . $word . '%')
                            ->orWhere('content', 'ILIKE', '%' . $word . '%');
                    }
                })
                ->orderByRaw("ts_rank(tsv, to_tsquery(?)) DESC", [$tsQuery])
                ->get();
        }

    }

    public static function filterByTags($articles, $tags)
    {
        return $articles->filter(function($article) use ($tags) {
            return !$article->is_deleted && $article->tags->pluck('id')->intersect($tags->pluck('id'))->isNotEmpty();
        });
    }

    public static function filterByTopics($articles, $topics)
    {
        return $articles->filter(function($article) use ($topics) {
            return !$article->is_deleted && $topics->pluck('id')->contains($article->topic->id);
        });
    }

    public static function getAllArticlesNonDeleted()
    {
        return self::where('is_deleted', false)
            ->whereHas('author', function ($query) {
                $query->where('is_banned', false);
            })
            ->get();
    }

    public static function filterDeletedArticles($articles)
    {
        return $articles->filter(function($article) {
            return !$article->is_deleted;
        });
    }

    //TRAN02
    public function voteArticleTransaction($userId, $articleId, $voteType, $userTo, $userFrom, $ntfDate)
    {
        DB::transaction(function () use ($userId, $articleId, $voteType, $userTo, $userFrom, $ntfDate) {
            // Check if the user has already voted on the article
            $existingVote = DB::table('vote_article')
                ->where('user_id', $userId)
                ->where('article_id', $articleId)
                ->first();

            if ($existingVote) {
                // Remove the existing vote
                DB::table('vote_article')
                    ->where('user_id', $userId)
                    ->where('article_id', $articleId)
                    ->delete();

                // Decrement the appropriate vote count
                if ($existingVote->type === 'Upvote') {
                    $this->where('id', $articleId)->decrement('upvotes');
                } else {
                    $this->where('id', $articleId)->decrement('downvotes');
                }
            }

            // Insert the new vote
            DB::table('vote_article')->insert([
                'user_id' => $userId,
                'article_id' => $articleId,
                'type' => $voteType
            ]);

            // Increment the appropriate vote count
            if ($voteType === 'Upvote') {
                $this->where('id', $articleId)->increment('upvotes');
            } else {
                $this->where('id', $articleId)->increment('downvotes');
            }

            // Check if the user has upvote notifications enabled
            $isNtfy = DB::table('users')->where('id', $userTo)->value('upvote_notification');

            if ($isNtfy) {
                // Insert into Notification and fetch the ID
                $ntfId = DB::table('notifications')->insertGetId([
                    'ntf_date' => $ntfDate,
                    'user_to' => $userTo,
                    'user_from' => $userFrom
                ]);

                // Insert into UpvoteArticleNotification using the fetched notification ID
                DB::table('upvote_article_notification')->insert([
                    'ntf_id' => $ntfId,
                    'article_id' => $articleId
                ]);
            }
        }, 5);
    }

}
