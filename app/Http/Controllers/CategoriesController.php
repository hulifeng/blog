<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Article;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category)
    {
        $articles = Article::where('category_id', $category->id)->where('is_hidden', '1')->paginate();

        // 热搜（默认浏览量在 Top 10 的）
        $hot_articles = Article::select('id', 'title')->orderBy('view_count', 'desc')->limit(5)->get();

        return view('home', compact('articles', 'hot_articles'));
    }
}
