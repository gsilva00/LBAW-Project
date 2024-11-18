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


    public function articles(): HasMany
    {
        return $this->hasMany(ArticlePage::class, 'topic_id');
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'FollowTopic',
            'topic_id',
            'user_id'
        );
    }
}
