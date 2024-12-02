<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    const CREATED_AT = 'report_date';
    const UPDATED_AT = null;

    protected $table = 'report';

    protected $fillable = [
        'description',
        'reporter_id',
    ];

    protected $attributes = [
        'is_accepted' => false,
    ];


    // Relationships
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }


    // Querying
    // ...
}
