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
        // Log::info('HomepageController show function called');

        /**
         * @var User $user
         * Return type of Auth::user() guaranteed on config/auth.php's User Providers
         */
        $user = Auth::user();

        $articleItems = ArticlePage::getAllArticlesNonDeleted();
        $trendingTags = Tag::trending()->take(5)->get();
        $recentNews = ArticlePage::getMostRecentNews(2);

        return view('pages.homepage', [
            'user' => $user,
            'articleItems' => $articleItems,
            'trendingTags' => $trendingTags,
            'recentNews' => $recentNews,
            'isHomepage' => true
        ]);
    }
}