<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
}
