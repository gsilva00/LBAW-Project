<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomepageController extends Controller
{
    /**
     * Show the welcome page.
     */
    public function show(): View
    {
        return view('pages.homepage', [
            'user' => Auth::user(),
            'articleItems' => ArticlePage::getAllArticlesNonDeleted(),
            'trendingTags' => Tag::trending()->take(5)->get(),
            'recentNews' => ArticlePage::getMostRecentNews(2),
            'isHomepage' => true
        ]);
    }
}