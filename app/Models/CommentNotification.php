<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentNotification extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'comment_notification';

    protected $fillable = [
        'ntf_id',
        'comment_id',
    ];


    // Relationships
    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class, 'ntf_id');
    }


    // Querying
    // ...

}