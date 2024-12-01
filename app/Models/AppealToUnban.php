<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppealToUnban extends Model
{
    use HasFactory;

    protected $table = 'appeal_to_unban';

    protected $fillable = [
        'description',
        'user_id',
    ];


    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }


    // Querying
    // ...
}