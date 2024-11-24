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

    public function scopeTrending($query)
    {
        return $query->where('is_trending', true);
    }
}
