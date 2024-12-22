<?php

namespace App\Policies;

use App\Models\ProposeNewTag;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ProposeNewTagPolicy
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
        // Only admins can view list of Tag Proposals
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProposeNewTag $proposeNewTag): bool
    {
        return Auth::check() && !$user->is_banned && $proposeNewTag->user()->is($user);
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
    public function update(User $user, ProposeNewTag $proposeNewTag): bool
    {
        return Auth::check() && !$user->is_banned && $proposeNewTag->user()->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProposeNewTag $proposeNewTag): bool
    {
        // Only admins can delete tag proposals
        return Auth::check() && !$user->is_banned && $proposeNewTag->user()->is($user);
    }


    /**
     * Determine whether the user can accept the model.
     */
    public function accept(User $user, ProposeNewTag $proposeNewTag): bool
    {
        // Only admins can accept tag proposals
        return false;
    }

    /**
     * Determine whether the user can reject the model.
     */
    public function reject(User $user, ProposeNewTag $proposeNewTag): bool
    {
        // Only admins can reject tag proposals
        return false;
    }
}
