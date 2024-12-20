<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use App\Models\User;
use Illuminate\Contracts\View\View;
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
        $user = User::find($username);

        $this->authorize('view', $user);

        $ownedArticles = $user->ownedArticles()->get();
        $ownedArticles = ArticlePage::filterDeletedArticles($ownedArticles);

        /*Log::info('ProfileController@show called', [
            'user' => $user,
            'ownedArticles' => $ownedArticles,
        ]);*/

        return view('pages.profile', [
            'user' => $authUser,
            'profileUser' => $user,
            'isAdmin' => $authUser ? $authUser->is_admin : false,
            'isOwner' => $authUser && $user->username === $authUser->username,
            'ownedArticles' => $ownedArticles,
        ]);
    }

    /**
     * Show the user profile edit form.
     */
    public function showEdit(string $username): View|RedirectResponse
    {
        /** @var User $authUser */
        $authUser = Auth::user();
        $user = User::find($username);

        if (Auth::guest() || $authUser->cant('update', $user)) {
            return redirect()->route('homepage')->with('error', 'Unauthorized. You do not possess the valid credentials to access that page.');
        }

        return view('pages.edit_profile', [
            'user' => $authUser,
            'profileUser' => $user,
            'isOwner' => $user->username === $authUser->username,
        ]);
    }

    /**
     * Update the user profile.
     */
    public function update(string $username): RedirectResponse
    {
        /** @var User $authUser */
        $authUser = Auth::user();
        $user = User::find($username);

        if (Auth::guest() || $authUser->cant('update', $user)) {
            return redirect()->route('homepage')->with('error', 'Unauthorized. You do not possess the valid credentials to edit that profile.');
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
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!$authUser->is_admin && !Hash::check(request('cur_password'), $user->password)) {
            return redirect()->back()->withErrors(['cur_password' => 'Current password is incorrect'])->withInput();
        }

        Log::info("Request: ", [
            'username' => request('username'),
            'email' => request('email'),
            'display_name' => request('display_name'),
            'description' => request('description'),
            'new_password' => request('new_password'),
            'profile_picture' => request('profile_picture'),
            'upvote_notification' => request('upvote-notifications'),
            'comment_notification' => request('comment-notifications'),
            'tupvote_notification' => request('upvote-notifications') === 'on',
            'tcomment_notification' => request('comment-notifications') === 'on',
        ]);

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

        Log::info("User updated: ", [
            'username' => $user->username,
            'email' => $user->email,
            'display_name' => $user->display_name,
            'description' => $user->description,
            'profile_picture' => $user->profile_picture,
            'upvote_notification' => $user->upvote_notification,
            'comment_notification' => $user->comment_notification,
        ]);

        return redirect()->route('profile', ['username' => $user->username])->with('success', 'Profile updated successfully!');
    }

    public function delete(Request $request, $targetUserId): View|RedirectResponse
    {
        /** @var User $authUser */
        $authUser = Auth::user();
        $targetUser = User::findOrFail($targetUserId);

        $this->authorize('delete', $targetUser);

        $request->validate([
            'cur_password_delete' => $authUser->is_admin ? 'nullable|string' : 'required|string',
        ]);

        if (!$authUser->is_admin && !Hash::check($request->input('cur_password_delete'), $authUser->password)) {
            return redirect()->back()->withErrors(['cur_password_delete' => 'Current password is incorrect'])->withInput();
        }

        $targetUser->deleteUserTransaction($targetUserId);

        if ($authUser->id === $targetUser->id) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('success', 'Your account has been deleted successfully.');
        }

        return redirect()->route('adminPanel')->with('success', 'User account deleted successfully!');
    }
}
