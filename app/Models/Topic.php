<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'topic';

    protected $fillable = ['name'];


    // Relationships
    public function articles(): HasMany
    {
        return $this->hasMany(ArticlePage::class, 'topic_id');
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'follow_topic',
            'topic_id',
            'user_id'
        );
    }


    // Querying
    public static function findTopicByName($topic)
    {
        return Topic::where('name', $topic)->first();
    }


}
