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
    public function viewAny(?User $authUser): bool
    {
        // Admins can view list of Users (profiles)
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $authUser, User $targetUser): bool
    {
        // Any user can view profiles
        return true;
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

    /**
     * Determine whether the user can access his followed tags
     */
    public function viewFollowingTags(User $authUser): bool
    {
        // Only authenticated users can follow tags
        return Auth::check();
    }
    /**
     * Determine whether the user can access his followed topics
     */
    public function viewFollowingTopics(User $authUser): bool
    {
        // Only authenticated users can follow topics
        return Auth::check();
    }

    public function viewFollowingAuthors(User $authUser): bool
    {
        return Auth::check();
    }

    /**
     * Determine wether the user can access the administrator panel
     */
    public function viewAdminPanel(User $authUser): bool
    {
        // Only admins can view the administrator panel.
        return false;
    }


    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $authUser, User $targetUser): bool
    {
        // Only admins can revert soft-deleted profiles.
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $authUser, User $targetUser): bool
    {
        // Only admins can permanently delete a user from the database.
        return false;
    }
}
