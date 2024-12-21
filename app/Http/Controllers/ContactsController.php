<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class ContactsController extends Controller
{
    public function show(): View
    {
        return view('pages.contacts', [
            'user' => Auth::user()
        ]);
    }
}
