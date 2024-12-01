<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProposeNewTag extends Model
{
    use HasFactory;

    protected $table = 'propose_new_tag';

    protected $fillable = [
        'name',
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