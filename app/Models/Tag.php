<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'tag';

    protected $fillable = [
        'name',
        'is_trending'
    ];
    protected $attributes = [
        'is_trending' => false,
    ];


    // Relationships
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(
            ArticlePage::class,
            'article_tag',
            'tag_id',
            'article_id'
        );
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'follow_tag',
            'tag_id',
            'user_id'
        );
    }


    // Querying
    public function scopeTrending($query)
    {
        return $query->where('is_trending', true);
    }

    public static function searchByArrayNames($tags): array
    {
        $tagIds = [];
        foreach ($tags as $tagName) {
            $tag = Tag::where('name', $tagName)->first();
            $tagIds[] = $tag->id;
        }
        return $tagIds;
    }

    public static function removeAllTagsByArticleId($articleId): void
    {
        $article = ArticlePage::find($articleId);
        if ($article) {
            $article->tags()->detach();
        }
    }

    public static function searchByArticleId($articleId)
    {
        return Tag::whereHas('articles', function ($query) use ($articleId) {
            $query->where('article_id', $articleId);
        })->get();
    }


}
