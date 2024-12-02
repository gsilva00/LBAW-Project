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
        return Auth::check() && $appealToUnban->user()->is($user);
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
        return Auth::check() && $appealToUnban->user()->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AppealToUnban $appealToUnban): bool
    {
        return Auth::check() && $appealToUnban->user()->is($user);
    }

}
