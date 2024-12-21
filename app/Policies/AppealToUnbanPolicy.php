<?php

namespace App\Policies;

use App\Models\AppealToUnban;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class AppealToUnbanPolicy
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
    public function viewAny(User $user): bool
    {
        // Only admins can view list of Unban Appeals
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AppealToUnban $appealToUnban): bool
    {
        return Auth::check() && $user->is_banned && $appealToUnban->user()->is($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Auth::check() && $user->is_banned;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AppealToUnban $appealToUnban): bool
    {
        return Auth::check() && $user->is_banned && $appealToUnban->user()->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AppealToUnban $appealToUnban): bool
    {
        return Auth::check() && $user->is_banned && $appealToUnban->user()->is($user);
    }


    /**
     * Determine whether the user can accept the model.
     */
    public function accept(User $user, AppealToUnban $appealToUnban): bool
    {
        // Only admins can accept tag proposals
        return false;
    }

    /**
     * Determine whether the user can reject the model.
     */
    public function reject(User $user, AppealToUnban $appealToUnban): bool
    {
        // Only admins can reject tag proposals
        return false;
    }
}
