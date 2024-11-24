<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomepageController extends Controller
{
    /**
     * Show the welcome page.
     */
    public function show()
    {
        Log::info('HomepageController@show called');
        $user = Auth::user();
        $articleItems = ArticlePage::all();
        $trendingTags = Tag::trending()->take(5)->get();
        $recentNews = ArticlePage::getMostRecentNews(2);

        return view('pages.homepage', ['articleItems' => $articleItems, 'trendingTags' => $trendingTags, 'recentNews' => $recentNews, 'isHomepage' => true, 'user' => $user]);
    }
}