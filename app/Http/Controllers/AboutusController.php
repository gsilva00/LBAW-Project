<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AboutusController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $username = $user->username ?? 'Guest';
        return view('pages.aboutus', ['username' => $username]);
    }
}
