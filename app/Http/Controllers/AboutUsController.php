<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AboutUsController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $username = $user->username ?? 'Guest';
        return view('pages.about_us', ['user' => $user]);
    }
}
