<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function show(Request $request)
    {
        $authUser = Auth::user();
        $searchQuery = $request->input('search');

        if (preg_match('/^".*"$/', $searchQuery)) {
            // Remove the double quotes
            $exactQuery = trim($searchQuery, '"');
            $articles = ArticlePage::where('title', 'ILIKE', '%' . $exactQuery . '%')
                ->orWhere('subtitle', 'ILIKE', '%' . $exactQuery . '%')
                ->orWhere('content', 'ILIKE', '%' . $exactQuery . '%')
                ->get();
        } else {
            $words = explode(' ', $searchQuery);
            $tsQuery = implode(' & ', array_map(function($word) {
                return $word . ':*';
            }, $words));

            $articles = ArticlePage::whereRaw("tsv @@ to_tsquery('english', ?)", [$tsQuery])
                ->orWhere(function($query) use ($words) {
                    foreach ($words as $word) {
                        $query->orWhere('title', 'ILIKE', '%' . $word . '%')
                            ->orWhere('subtitle', 'ILIKE', '%' . $word . '%')
                            ->orWhere('content', 'ILIKE', '%' . $word . '%');
                    }
                })
                ->orderByRaw("ts_rank(tsv, to_tsquery('english', ?)) DESC", [$tsQuery])
                ->get();
        }

        return view('pages.search', [
            'searchQuery' => $searchQuery,
            'username' => $authUser->username ?? 'Guest',
            'articleItems' => $articles
        ]);
    }
}