<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class FeaturesController extends Controller
{
    public function show(): View
    {
        return view('pages.features', ['user' => Auth::user()]);
    }
}
