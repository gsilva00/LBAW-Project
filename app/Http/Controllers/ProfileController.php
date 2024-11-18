<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the user profile.
     */
    public function show(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        // You can pass user data to the view if needed
        $user = Auth::user();
        $username = $user->username ?? 'Guest';
        $usermail = $user->email ?? 'Guest@up.pt';
        return view('pages.profile', ['username' => $username, 'usermail' => $usermail]);
    }
}
