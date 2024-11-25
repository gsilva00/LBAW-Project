<?php

namespace App\Http\Controllers;

use App\Models\ArticlePage;
use App\Models\Tag;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CreateArticleController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        Log::info('CreateArticleController@show', [
            'title' => $request->input('title'),
            'subtitle' => $request->input('subtitle'),
            'content' => $request->input('content'),
            'tags' => $request->input('tags'),
            'topics' => $request->input('topics'),
            'article_picture' => $request->file('article_picture'),
        ]);

        $request->validate([
            'title' => 'required|string|max:50',
            'subtitle' => 'required|string|max:50',
            'content' => 'string|max:10000',
            'topics' => 'required|exists:topic,id',
            'article_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        Log::info('CreateArticleController@show: validation passed');
        $topicId = intval($request->input('topics')[0]);

        $article = new ArticlePage();
        $article->title = $request->input('title');
        $article->subtitle = $request->input('subtitle');
        $article->content = str_replace("\n", "<?n?n>", $request->input('content'));
        $article->author_id = Auth::id();
        $article->topic_id = $topicId;

        if ($request->hasFile('article_picture')) {
            $imageName = time() . '-' . $request->file('article_picture')->getClientOriginalName();
            $request->file('article_picture')->move(public_path('images/article'), $imageName);
            $article->article_image = $imageName;
        }

        $article->save();

        $tagIds = Tag::searchByArrayNames($request->input('tags', []));
        $article->tags()->sync($tagIds);

        return redirect()->route('profile', ['username' => $user->username])->with('success', 'Article created successfully!');
    }

    public function create(){
        $user = Auth::user();

        $this->authorize('create', ArticlePage::class);

        return view('pages.create_article', ['user' => $user]);
    }

    public function edit(Request $request, $id){
        $user = Auth::user();
        $article = ArticlePage::findOrFail($id);

        $this->authorize('update', $article);

        return view('pages.edit_article', ['user' => $user, 'article' => $article]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $article = ArticlePage::findOrFail($id);

        $this->authorize('update', $article);

        $request->validate([
            'title' => 'required|string|max:50',
            'subtitle' => 'required|string|max:50',
            'content' => 'string|max:10000',
        ]);

        Log::info('CreateArticleController@show', [
            'title' => $request->input('title'),
            'subtitle' => $request->input('subtitle'),
            'content' => $request->input('content')
        ]);

        $article->title = $request->input('title');
        $article->subtitle = $request->input('subtitle');
        $article->content = $request->input('content');
        $article->save();

        return redirect()->route('profile', ['username' => $user->username])->with('success', 'Article updated successfully!');
    }

    public function delete(Request $request, $id)
    {
        $user = Auth::user();
        $article = ArticlePage::findOrFail($id);

        $this->authorize('delete', $article);

        $article->is_deleted = true;
        $article->title = '[Deleted]';
        $article->subtitle = 'This is article has been deleted';
        $article->content = '[Deleted]';
        $article->save();

        return redirect()->route('profile', ['username' => $user->username])->with('success', 'Article deleted successfully!');
    }

}
