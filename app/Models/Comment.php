<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    use HasFactory;

    const CREATED_AT = 'cmt_date';
    const UPDATED_AT = null;

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


    // Relationships
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

    public static function filterBySearchQuery($searchQuery)
    {
        if (empty($searchQuery)) {
            return self::where('is_deleted', false)->get();
        } elseif (preg_match('/^".*"$/', $searchQuery)) {
            $exactQuery = trim($searchQuery, '"');
            return self::where('is_deleted', false)
                ->where(function($query) use ($exactQuery) {
                    $query->where('content', 'ILIKE', '% ' . $exactQuery)
                        ->orWhere('content', 'ILIKE', $exactQuery . ' %')
                        ->orWhere('content', 'ILIKE', '% ' . $exactQuery . ' %')
                        ->orWhere('content', 'ILIKE', $exactQuery);
                })
                ->get();
        } else {
            $words = explode(' ', $searchQuery);
            $sanitizedWords = array_map(function($word) {
                return $word . ':*';
            }, $words);
            $tsQuery = implode(' & ', $sanitizedWords);

            return self::where('is_deleted', false)
                ->whereRaw("full_text_vector @@ to_tsquery(?)", [$tsQuery])
                ->orWhere(function($query) use ($words) {
                    foreach ($words as $word) {
                        $query->orWhere('content', 'ILIKE', '%' . $word . '%');
                    }
                })
                ->orderByRaw("ts_rank(full_text_vector, to_tsquery(?)) DESC", [$tsQuery])
                ->get();
        }
    }

    //TRAN03
    public function voteCommentTransaction($userId, $commentId, $voteType, $userTo, $userFrom, $ntfDate)
    {
        DB::transaction(function () use ($userId, $commentId, $voteType, $userTo, $userFrom, $ntfDate) {
            $existingVote = DB::table('vote_comment')
                ->where('user_id', $userId)
                ->where('comment_id', $commentId)
                ->first();

            if ($existingVote) {
                DB::table('vote_comment')
                    ->where('user_id', $userId)
                    ->where('comment_id', $commentId)
                    ->delete();

                if ($existingVote->type === 'Upvote') {
                    $this->where('id', $commentId)->decrement('upvotes');
                } else {
                    $this->where('id', $commentId)->decrement('downvotes');
                }
            }

            DB::table('vote_comment')->insert([
                'user_id' => $userId,
                'comment_id' => $commentId,
                'type' => $voteType
            ]);

            if ($voteType === 'Upvote') {
                $this->where('id', $commentId)->increment('upvotes');
            } else {
                $this->where('id', $commentId)->increment('downvotes');
            }

            $isNtfy = DB::table('users')->where('id', $userTo)->value('upvote_notification');

            if ($isNtfy) {
                $ntfId = DB::table('notifications')->insertGetId([
                    'ntf_date' => $ntfDate,
                    'user_to' => $userTo,
                    'user_from' => $userFrom
                ]);

                DB::table('upvote_comment_notification')->insert([
                    'ntf_id' => $ntfId,
                    'comment_id' => $commentId
                ]);
            }
        }, 5);
    }



}
