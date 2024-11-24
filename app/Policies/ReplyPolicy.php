<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ReplyPolicy
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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Reply $reply): bool
    {
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
    public function update(User $user, Reply $reply): bool
    {
        return Auth::check() && $reply->author()->is($user) && !$user->is_banned;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Reply $reply): bool
    {
        return Auth::check() && $reply->author()->is($user) && !$user->is_banned;
    }


    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Reply $reply): bool
    {
        // Only admins can permanently delete a reply from the database.
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Reply $reply): bool
    {
        // Only admins can permanently delete a reply from the database.
        return false;
    }
}
