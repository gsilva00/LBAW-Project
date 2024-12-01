<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AskToBecomeFactChecker extends Model
{
    use HasFactory;

    protected $table = 'ask_to_become_fact_checker';

    protected $fillable = [
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
}