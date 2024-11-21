<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Tag;
use App\Models\Topic;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Use a view composer to share tags and topics with all views
        View::composer('*', function ($view) {
            $tags = Tag::all();
            $topics = Topic::all();
            $view->with('tags', $tags)->with('topics', $topics);
        });
    }
}