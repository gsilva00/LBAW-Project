<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportComment extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'report_comment';

    protected $fillable = [
        'type',
        'report_id',
        'comment_id',
        'reply_id',
    ];

    protected $attributes = [
        'type' => 'Spam', // Default to one of the allowed values
    ];


    // Relationships
    /**
     * Retrieve the reported comment or reply.
     */
    public function reportedEntity(): belongsTo|null
    {
        if ($this->comment_id) {
            return $this->belongsTo(Comment::class, 'comment_id');
        } elseif ($this->reply_id) {
            return $this->belongsTo(Reply::class, 'reply_id');
        }

        return null; // Will not happen (due to schema constraints)
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class, 'report_id');
    }


    // Querying
    // ...

}