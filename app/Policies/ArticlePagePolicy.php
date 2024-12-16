<?php

namespace App\Policies;

use App\Models\ArticlePage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ArticlePagePolicy
{

    /**
     * Perform pre-authorization checks.
     *
     * Admins can do everything.
     * When null, the authorization check falls through to the respective policy method.
     */
    public function before(User $user, $ability): bool|null
    {
        if (Auth::check() && $user->is_admin) {
            return true;
        }

        return null;
    }


    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        // Any user can view a list of articles
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * '?' in the user argument to allow authorization check to reach this method
     */
    public function view(?User $user, ArticlePage $articlePage): bool
    {
        // Any user can view a specific article
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Auth::check() && !$user->is_banned;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ArticlePage $articlePage): bool
    {
        return Auth::check() && !$user->is_banned && $articlePage->author()->is($user) && !$articlePage->is_deleted;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ArticlePage $articlePage): bool
    {
        return Auth::check() && !$user->is_banned && $articlePage->author()->is($user) && !$articlePage->is_deleted;
    }


    public function upvote(User $user, ArticlePage $articlePage): bool
    {
        return Auth::check() && !$user->is_banned && !$articlePage->is_deleted;
    }
    public function downvote(User $user, ArticlePage $articlePage): bool
    {
        return Auth::check() && !$user->is_banned && !$articlePage->is_deleted;
    }
    public function favourite(User $user, ArticlePage $articlePage): bool
    {
        return Auth::check() && !$user->is_banned && !$articlePage->is_deleted;
    }
    public function report(User $user, ArticlePage $articlePage): bool
    {
        return Auth::check() && !$user->is_banned && !$articlePage->is_deleted;
    }
}
