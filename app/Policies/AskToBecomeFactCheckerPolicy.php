<?php

namespace App\Policies;

use App\Models\AskToBecomeFactChecker;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class AskToBecomeFactCheckerPolicy
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
        // Only admins can view list of Fact Checker Requests
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AskToBecomeFactChecker $atbfc): bool
    {
        return Auth::check() && !$user->is_banned && $atbfc->user()->is($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Auth::check() && !$user->is_banned && !$user->is_fact_checker;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AskToBecomeFactChecker $atbfc): bool
    {
        return Auth::check() && !$user->is_banned && $atbfc->user()->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AskToBecomeFactChecker $atbfc): bool
    {
        return Auth::check() && !$user->is_banned && $atbfc->user()->is($user);
    }
}
