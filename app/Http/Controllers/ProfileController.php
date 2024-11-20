<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the user profile.
     */
    public function show(string $username): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $user = User::find($username);
        $displayName = $user->display_name;
        $authUser = Auth::user();
        $authUsername = $authUser->username ?? 'Guest';
        return view('pages.profile', [
            'username' => $authUsername,
            'profileUsername' => $username,
            'displayName' => $displayName,
            'isOwner' => $user->username === $authUser->username
        ]);
    }
}
