<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    /**
     * Perform pre-authorization checks.
     *
     * Admins can do everything.
     * When null, the authorization check falls through to the respective policy method.
     */
    public function before(User $authUser, $ability): bool|null
    {
        if (Auth::check() && $authUser->is_admin) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $authUser): bool
    {
        // Admins can view list of Users (profiles)
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $authUser, User $targetUser): bool
    {
        // Any user can view profiles of non-deleted users
        return !$targetUser->is_deleted;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $authUser): bool
    {
        // Admins can create new users.
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authUser, User $targetUser): bool
    {
        // Users can update their own profile
        return Auth::check() && $authUser->is($targetUser);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $authUser, User $targetUser): bool
    {
        // Users can delete their own profile
        return Auth::check() && $authUser->is($targetUser);
    }



    public function login(?User $authUser): bool
    {
        // Only unauthenticated users can log in
        return !Auth::check();
    }
    public function logout(User $authUser): bool
    {
        // Only authenticated users can log out
        return Auth::check();
    }
    public function register(?User $authUser): bool
    {
        // Only unauthenticated users can register
        return !Auth::check();
    }
    public function recoverPassword(?User $authUser): bool
    {
        // Only unauthenticated users can recover their password
        return !Auth::check();
    }


    public function viewUserFeed(User $authUser): bool
    {
        return Auth::check();
    }

    public function viewFollowingTags(User $authUser): bool
    {
        // Only authenticated users can access their followed tags
        return Auth::check();
    }

    public function viewFollowingTopics(User $authUser): bool
    {
        // Only authenticated users can access their followed topics
        return Auth::check();
    }

    public function viewFollowingAuthors(User $authUser): bool
    {
        // Only authenticated users can access their followed authors
        return Auth::check();
    }

    public function viewAdminPanel(User $authUser): bool
    {
        // Only admins can view the administrator panel.
        return false;
    }

    public function followUser(User $authUser, User $targetUser): bool
    {
        return Auth::check() && !$authUser->is_banned && !$targetUser->is_banned;
    }
    public function unfollowUser(User $authUser, User $targetUser): bool
    {
        return Auth::check() && !$authUser->is_banned && !$targetUser->is_banned;
    }

    public function report(User $authUser, User $targetUser): bool
    {
        return Auth::check() && !$authUser->is_banned && !$targetUser->is_banned;
    }

    public function ban(User $authUser, User $targetUser): bool
    {
        // Only admins can ban users
        return false;
    }

    public function unban(User $authUser, User $targetUser): bool
    {
        // Only admins can unban users
        return false;
    }
}
