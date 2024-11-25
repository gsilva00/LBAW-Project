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

        $this->authorize('view', $user);

        $ownedArticles = $user->ownedArticles()->get();
        $ownedArticles = ArticlePage::filterDeletedArticles($ownedArticles);

        Log::info('ProfileController@show called', [
            'user' => $user,
            'ownedArticles' => $ownedArticles,
        ]);

        $authUser = Auth::user();
        return view('pages.profile', [
            'userprofile' => $user,
            'isAdmin' => $authUser->is_admin,
            'isOwner' => $user->username === $authUser->username,
            'ownedArticles' => $ownedArticles,
            'user' => $authUser,
        ]);
    }

    /**
     * Show the user profile edit form.
     */
    public function edit()
    {
        $user = Auth::user();
        $authUser = Auth::user();

        $this->authorize('update', $user);

        return view('pages.profile_edit', [
            'user' => $user,
            'isOwner' => $user->username === $authUser->username,
        ]);
    }

    /**
     * Update the user profile.
     */
    public function update(): RedirectResponse
    {
        $user = Auth::user();

        $this->authorize('update', $user);

        $validator = Validator::make(request()->all(), [
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'cur_password' => 'required|string',
            'new_password' => 'nullable|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!Hash::check(request('cur_password'), $user->password)) {
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

        return redirect()->route('profile', ['username' => $user->username]);
    }

    public function delete(Request $request, $targetUserId)
    {
        $authUser = Auth::user();
        $targetUser = User::findOrFail($targetUserId);

        $this->authorize('delete', $authUser);

        $targetUser->is_deleted = true;
        $targetUser->save();

        if ($authUser->id === $targetUser->id) {
            Auth::logout();  // Log out the user
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('success', 'Your account has been deleted successfully.');
        }

        return redirect()->route('admin-panel')->with('success', 'User account deleted successfully!');
    }
}
