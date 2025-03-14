<?php

namespace App\Http\Controllers;

use App\Models\AppealToUnban;
use App\Models\ArticlePage;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Show the user's profile.
     */
    public function showProfile(string $username): View
    {
        /**
         * @var User $authUser
         * Return type of Auth::user() guaranteed on config/auth.php's User Providers
         */
        $authUser = Auth::user();
        $user = User::where('username', $username)->firstOrFail();

        $this->authorize('view', $user);

        $ownedArticles = $user->ownedArticles()->get();
        $ownedArticles = ArticlePage::filterDeletedArticles($ownedArticles);

        return view('pages.profile', [
            'user' => $authUser,
            'profileUser' => $user,
            'isAdmin' => $authUser ? $authUser->is_admin : false,
            'isOwner' => $authUser && $user->username === $authUser->username,
            'ownedArticles' => $ownedArticles
        ]);
    }

    /**
     * Show the user profile edit form.
     */
    public function showEdit(string $username): View|RedirectResponse
    {
        /** @var User $authUser */
        $authUser = Auth::user();
        $user = User::where('username', $username)->firstOrFail();

        try {
            $this->authorize('update', $user);
        }
        catch (AuthorizationException $e) {
            return redirect()->route('homepage')
                ->withErrors('Unauthorized. You do not possess the valid credentials to access that page.');
        }

        return view('pages.edit_profile', [
            'user' => $authUser,
            'profileUser' => $user,
            'isOwner' => $user->id === $authUser->id,
        ]);
    }

    /**
     * Update the user profile.
     */
    public function update(string $username): RedirectResponse
    {
        /** @var User $authUser */
        $authUser = Auth::user();
        $user = User::where('username', $username)->firstOrFail();

        try {
            $this->authorize('update', $user);
        }
        catch (AuthorizationException $e) {
            return redirect()->route('homepage')
                ->withErrors('Unauthorized. You do not possess the valid credentials to perform that action.');
        }

        $validator = Validator::make(request()->all(), [
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'cur_password' => $authUser->is_admin ? 'nullable|string' : 'required|string',
            'new_password' => 'nullable|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)->withInput();
        }

        if (!$authUser->is_admin && !Hash::check(request('cur_password'), $user->password)) {
            return redirect()->back()
                ->withErrors(['cur_password' => 'Current password is incorrect'])->withInput();
        }

        $user->username = request('username');
        $user->email = request('email');
        $user->display_name = request('display_name');
        $user->description = request('description');
        $user->upvote_notification = request('upvote-notifications') === 'on';
        $user->comment_notification = request('comment-notifications') === 'on';

        if (request('file')) {
            $fileController = new FileController();

            if ($user->profile_picture !== 'default.jpg') {
                $imageName = $fileController->uploadImage(request(), 'profile', $user->profile_picture);
            }
            else {
                $imageName = $fileController->uploadImage(request(), 'profile');
            }

            $user->profile_picture = $imageName;
        }

        if (request('new_password')) {
            $user->password = Hash::make(request('new_password'));
        }

        $user->save();

        return redirect()->route('profile', ['username' => $user->username])
            ->withSuccess('Profile updated successfully!');
    }

    public function delete(Request $request, $targetUserId): View|RedirectResponse|JsonResponse
    {
        /** @var User $authUser */
        $authUser = Auth::user();
        $targetUser = User::findOrFail($targetUserId);
        $isOwner = $authUser->id === $targetUser->id;

        $this->authorize('delete', $targetUser);

        if (!$isOwner && $targetUser->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete an admin account.'
            ], 403);
        }

        $request->validate([
            'cur_password_delete' => $authUser->is_admin ? 'nullable|string' : 'required|string',
        ]);

        if ($isOwner && !Hash::check($request->input('cur_password_delete'), $authUser->password)) {
            return redirect()->back()
                ->withErrors('Current password is incorrect')->withInput();
        }

        $targetUser->deleteUserTransaction($targetUserId);

        if ($isOwner) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('homepage')
                ->withSuccess('Your account has been deleted successfully.');
        }

        return response()->json([
            'success' => true,
            'message' => 'User account deleted successfully.'
        ]);
    }

    public function appealUnbanShow(): View
    {
        return view('partials.appeal_unban');
    }

    public function appealUnbanSubmit(Request $request): JsonResponse
    {
        $appeal = new AppealToUnban();
        $appeal->description = $request->input('appealReason');
        $appeal->user_id = Auth::id();

        $appeal->save();

        return response()->json([
            'success' => true,
            'message' => 'Appeal submitted successfully!'
        ]);
    }

}
