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
     * When null, the authorization check falls through to the respective policy method.
     */
    public function before(User $user, $ability): bool|null
    {
        if ($user->is_admin) {
            return true;
        }

        return null;
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
        return Auth::check() && $articlePage->author()->is($user) && !$user->is_banned;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ArticlePage $articlePage): bool
    {
        return Auth::check() && $articlePage->author()->is($user) && !$user->is_banned;
    }


    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        // Only admins can revert soft-deleted articles.
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        // Only admins can permanently delete an article from the database.
        return false;
    }

}
