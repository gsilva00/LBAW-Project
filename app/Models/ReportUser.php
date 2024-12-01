<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportUser extends Report
{
    public $timestamps = false;

    protected $table = 'report_user';

    protected $fillable = [
        'type',
        'report_id',
        'user_id',
    ];

    protected $attributes = [
        'type' => 'Harassment', // Default to one of the allowed values
    ];

    /**
     * Get the user that was reported
     */
    public function reportedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the base report associated with this user report.
     */
    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class, 'report_id');
    }
}