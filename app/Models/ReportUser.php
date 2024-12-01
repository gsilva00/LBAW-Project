<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportUser extends Model
{
    use HasFactory;

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


    // Relationships
    public function reportedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class, 'report_id');
    }


    // Querying
    // ...

}