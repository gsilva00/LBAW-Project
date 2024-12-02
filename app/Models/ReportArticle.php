<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportArticle extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'report_article';

    protected $fillable = [
        'type',
        'report_id',
        'article_id',
    ];

    protected $attributes = [
        'type' => 'Fact Check', // Default to one of the allowed values
    ];


    // Relationships
    public function reportedArticle(): BelongsTo
    {
        return $this->belongsTo(ArticlePage::class, 'article_id');
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class, 'report_id');
    }


    // Querying
    // ...

}