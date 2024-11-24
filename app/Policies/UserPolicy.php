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
        // Admins can view list of Users (profiles)
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, User $model): bool
    {
        // Any user can view profiles
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Admins can create new users.
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Users can update their own profile
        return Auth::check() && $user->is($model);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Users can delete their own profile
        return Auth::check() && $user->is($model);
    }


    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        // Only admins can revert soft-deleted profiles.
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        // Only admins can permanently delete a user from the database.
        return false;
    }
}
