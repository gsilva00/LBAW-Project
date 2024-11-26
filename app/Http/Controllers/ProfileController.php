<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use App\Models\User;
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
    public function show(string $username)
    {
        $user = User::find($username);
        $authUser = Auth::user();

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
    public function edit(string $username)
    {
        $user = User::find($username);
        $authUser = Auth::user();

        $this->authorize('update', $user);

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
        $authUser = Auth::user();
        $user = User::find($username);

        $this->authorize('update', $user);

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

        $user->username = request('username');
        $user->email = request('email');
        $user->display_name = request('display_name');
        $user->description = request('description');

        if (request('profile_picture')) {
            $imageName = time() . '-' . request('profile_picture')->getClientOriginalName();
            request('profile_picture')->move(public_path('images/profile'), $imageName);
            $user->profile_picture = $imageName;
        }

        if (request('new_password')) {
            $user->password = Hash::make(request('new_password'));
        }

        $user->save();

        return redirect()->route('profile', ['username' => $user->username])->with('success', 'Profile updated successfully!');
    }

    public function delete(Request $request, $targetUserId)
    {
        $authUser = Auth::user();
        $targetUser = User::findOrFail($targetUserId);

        $this->authorize('delete', $targetUser);

        $request->validate([
            'cur_password_delete' => $authUser->is_admin ? 'nullable|string' : 'required|string',
        ]);

        // Check the password if the user is not an admin
        if (!$authUser->is_admin && !Hash::check($request->input('cur_password_delete'), $authUser->password)) {
            return redirect()->back()->withErrors(['cur_password_delete' => 'Current password is incorrect'])->withInput();
        }

        $targetUser->display_name = '[Deleted User]';
        $targetUser->username = '[deleted_user_' . $targetUserId . ']';
        $targetUser->email = '[deleted_user_' . $targetUserId . ']@example.com';
        $targetUser->password = '<PASSWORD>';
        $targetUser->profile_picture = 'images/profile/default.jpg';
        $targetUser->description = 'This user account has been deleted.';
        $targetUser->reputation = 0;
        $targetUser->upvote_notification = false;
        $targetUser->comment_notification = false;
        $targetUser->is_banned = false;
        $targetUser->is_admin = false;
        $targetUser->is_fact_checker = false;
        $targetUser->is_deleted = true;
        $targetUser->save();

        if ($authUser->id === $targetUser->id) {
            Auth::logout();  // Log out the user
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('success', 'Your account has been deleted successfully.');
        }

        return redirect()->route('adminPanel')->with('success', 'User account deleted successfully!');
    }
}
