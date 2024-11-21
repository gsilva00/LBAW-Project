<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Show the user profile.
     */
    public function show(string $username): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $user = User::find($username);
        $displayName = $user->display_name;
        $description = $user->description;
        $isBanned = $user->is_banned;
        $isAdmin = $user->is_admin;
        $ownedArticles = $user->ownedArticles()->get();

        $authUser = Auth::user();
        $authUsername = $authUser->username ?? 'Guest';
        return view('pages.profile', [
            'username' => $authUsername,
            'profileUsername' => $username,
            'isBanned' => $isBanned,
            'isAdmin' => $isAdmin,
            'displayName' => $displayName,
            'description' => $description,
            'profilePicture' => $user->profile_picture,
            'isOwner' => $user->username === $authUser->username,
            'ownedArticles' => $ownedArticles
        ]);
    }

    /**
     * Show the user profile edit form.
     */
    public function edit(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        return view('pages.profileEdit', [
            'username' => $user->username,
            'email' => $user->email,
            'password' => $user->password,
            'displayName' => $user->display_name,
            'description' => $user->description,
        ]);
    }

    /**
     * Update the user profile.
     */
    public function update(): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();

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
            $imageName = time() . '-' . request('profile_picture')->getClientOriginalName() . '.' . request('profile_picture')->extension();
            request('profile_picture')->move(public_path('images/profile'), $imageName);
            $user->profile_picture = $imageName;
        }

        if (request('new_password')) {
            $user->password = Hash::make(request('new_password'));
        }

        $user->save();

        return redirect()->route('profile', ['username' => $user->username]);
    }
}
