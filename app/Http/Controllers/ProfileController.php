<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Show the user profile.
     */
    public function show(string $username)
    {
        $user = User::find($username);
        $this->authorize('view', $user);

        $ownedArticles = $user->ownedArticles()->get();

        Log::info('ProfileController@show called', [
            'user' => $user,
            'ownedArticles' => $ownedArticles,
        ]);

        $authUser = Auth::user();
        return view('pages.profile', [
            'userprofile' => $user,
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
        Log::debug('ProfileController@edit called. Loading authorization...');
        $user = Auth::user();
        $this->authorize('update', $user);
        Log::debug('ProfileController@edit called and authorization passed');

        return view('pages.profile_edit', [
            'user' => $user,
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
}
