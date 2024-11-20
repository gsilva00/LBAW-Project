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
        $formattedQuery = str_replace(' ', ' & ', $searchQuery); // Format the query for to_tsquery
        $articles = ArticlePage::whereRaw("tsv @@ to_tsquery('english', ?)", [$formattedQuery])
            ->orderByRaw("ts_rank(tsv, to_tsquery('english', ?)) DESC", [$formattedQuery])
            ->get();


        return view('pages.search', [
            'searchQuery' => $searchQuery,
            'username' => $authUser->username ?? 'Guest',
            'articleItems' => $articles
        ]);
    }
}
