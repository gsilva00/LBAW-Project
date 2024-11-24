<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ContactsController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $username = $user->username ?? 'Guest';
        return view('pages.contacts', ['username' => $username, 'user' => $user]);
    }
}
