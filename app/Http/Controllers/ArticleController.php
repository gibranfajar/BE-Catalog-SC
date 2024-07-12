<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        return view('articles.index', compact('articles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'size_chart' => ['required']
        ]);

        $article = new Article();
        $article->name = $request->name;
        $article->slug = Str::slug($request->name);
        $article->description = $request->description;
        $article->size_chart = $request->size_chart;
        $article->save();

        return redirect()->route('articles')->with('success', 'Article created successfully');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'size_chart' => ['required']
        ]);

        $article = Article::find($request->id);
        $article->name = $request->name;
        $article->slug = Str::slug($request->name);
        $article->description = $request->description;
        $article->size_chart = $request->size_chart;
        $article->save();

        return redirect()->route('articles')->with('success', 'Article updated successfully');
    }
}
