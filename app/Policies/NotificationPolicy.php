<?php

namespace App\Policies;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class NotificationPolicy
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
        // TODO review this
        return Auth::check() && !$user->is_banned;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Notification $notification): bool
    {
        return Auth::check() && !$user->is_banned && $user->id === $notification->user_to;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // User cannot directly create a notification, is it created automatically according to actions
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Notification $notification): bool
    {
        // The recipient user can mark the notification as read
        return Auth::check() && !$user->is_banned && $user->id === $notification->user_to;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Notification $notification): bool
    {
        // User cannot delete a notification
        return false;
    }
}
