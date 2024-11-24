<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ContactsController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('pages.contacts', ['user' => $user]);
    }
}
