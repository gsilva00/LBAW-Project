<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false; // Don't add create and update timestamps in database.
    // protected $table = 'users'; - This is default Laravel conversion (lowercase camel_case model name)

    // The attributes that are mass assignable.
    protected $fillable = [
        'display_name',
        'username',
        'email',
        'password',
        'profile_picture',
        'description',
        'reputation',
        'upvote_notification',
        'comment_notification',
        'is_banned',
        'is_admin',
        'is_fact_checker',
        'is_deleted',
        'remember_token',
    ];

    // The model's default values for attributes.
    protected $attributes = [
        'display_name' => null,
        'profile_picture' => null,
        'description' => null,
        'reputation' => 3,
        'upvote_notification' => true,
        'comment_notification' => true,
        'is_banned' => false,
        'is_admin' => false,
        'is_fact_checker' => false,
        'is_deleted' => false,
        'remember_token' => null,
    ];

    // The attributes that should be hidden for serialization.
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // The attributes that should be cast.
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}