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
        $searchQuery = $this->sanitizeSearchQuery(trim($request->input('search')));

        if (empty($searchQuery)) {
            // Handle empty search query
            $articles = collect();
        } elseif (preg_match('/^".*"$/', $searchQuery)) {
            // Remove the double quotes
            $exactQuery = trim($searchQuery, '"');
            $articles = ArticlePage::where('title', 'ILIKE', '%' . $exactQuery . '%')
                ->orWhere('subtitle', 'ILIKE', '%' . $exactQuery . '%')
                ->orWhere('content', 'ILIKE', '%' . $exactQuery . '%')
                ->get();
        } else {
            $words = explode(' ', $searchQuery);
            $sanitizedWords = array_map(function($word) {
                return $word . ':*';
            }, $words);
            $tsQuery = implode(' & ', $sanitizedWords);

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


    private function sanitizeSearchQuery($query)
    {
        return preg_replace('/[^\w\s"]/', '', $query);
    }
}