<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomepageController extends Controller
{
    /**
     * Show the welcome page.
     */
    public function show(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        Log::info('HomepageController@show called');
        $user = Auth::user();
        $username = $user->username ?? 'Guest';
        $articleItems = ArticlePage::all();

        return view('pages.homepage', ['username' => $username, 'articleItems' => $articleItems]);
    }
}