<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticlePage extends Model
{
    use HasFactory;

    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'edit_date';


    protected $table = 'articlepage';

    protected $fillable = [
        'title',
        'subtitle',
        'content',
        'article_image',
        'upvotes',
        'downvotes',
        'is_edited',
        'is_deleted',
        'topic_id',
        'author_id',
    ];

    protected $attributes = [
        'edit_date' => null,
        'article_image' => null,
        'upvotes' => 0,
        'downvotes' => 0,
        'is_edited' => false,
        'is_deleted' => false,
    ];

}
