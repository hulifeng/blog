<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Article;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::where('is_hidden', '1')->paginate();

        // 热搜（默认浏览量在 Top 10 的）
        $hot_articles = Article::select('id', 'title')->orderBy('view_count', 'desc')->limit(5)->get();

        return view('home', compact('articles', 'hot_articles'));
    }
}
