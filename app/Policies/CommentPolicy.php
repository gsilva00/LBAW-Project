<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class CommentPolicy
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
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Comment $comment): bool
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
    public function update(User $user, Comment $comment): bool
    {
        return Auth::check() && !$user->is_banned && $comment->author()->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return Auth::check() && !$user->is_banned && $comment->author()->is($user);
    }


    public function upvote(User $user, Comment $comment): bool
    {
        return Auth::check() && !$user->is_banned && !$comment->is_deleted;
    }
    public function downvote(User $user, Comment $comment): bool
    {
        return Auth::check() && !$user->is_banned && !$comment->is_deleted;
    }
    public function report(User $user, Comment $comment): bool
    {
        return Auth::check() && !$user->is_banned && !$comment->is_deleted;
    }
}
