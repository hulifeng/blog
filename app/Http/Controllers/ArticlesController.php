<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;
use NoisyWinds\Smartmd\Markdown;

class ArticlesController extends Controller
{
    public function index()
    {
        $articles = Article::with('user')->paginate();

        return view('articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        $tags = $article->tags->pluck('name')->toArray();

        $article->increment('view_count');

        return view('articles.show', compact('article', 'tags'));
    }

    public function create(Article $article)
    {
        $tag = '';
        return view('articles.create_and_edit', compact('article', 'tag'));
    }

    public function store(Request $request)
    {
        $article = new Article;
        $parse = new Markdown();
        $article->title = $request->title;
        $article->cover = 'http://www.baidu.com';
        $article->content_html = $parse->text($request->content_markdown);
        $article->content_markdown = $request->content_markdown;
        $article->user_id = 1;
        $article->category_id = 1;
        $article->save();

        $tags = explode(',', $request->tags);

        for ($i = 0; $i < sizeof($tags); $i++) {
            $tag = Tag::where('name', $tags[$i])->first();
            // 检验标签是否存在
            if ($tag) {
                // 存在就更新关系表
                $article->tags()->attach($tag->id);
            } else {
                // 不存在，先创建标签，在更新关系表
                $tag = new Tag;
                $tag->name = $tags[$i];
                $tag->save();
                $article->tags()->attach($tag->id);
            }
        }

        return redirect()->route('home')->with('success', '文章发布成功！');
    }

    public function edit(Article $article)
    {
        $tags = $article->tags()->pluck('name')->toArray();
        if ($tags) {
            $tag = implode(',', $tags);
        } else {
            $tag = '';
        }
        return view('articles.create_and_edit', compact('article', 'tag'));
    }

    public function update(Request $request, Article $article)
    {
        $parse = new Markdown();
        $article->title = $request->title;
        $article->cover = 'http://www.baidu.com';
        $article->content_html = $parse->text($request->content_markdown);
        $article->content_markdown = $request->content_markdown;
        $article->user_id = 1;
        $article->category_id = 1;
        $article->save();

        // 删除当前文章的所有标签
        $article->tags()->detach();

        $tags = explode(',', $request->tags);

        for ($i = 0; $i < sizeof($tags); $i++) {
            $tag = Tag::where('name', $tags[$i])->first();
            // 检验标签是否存在
            if ($tag) {
                // 存在就更新关系表
                $article->tags()->attach($tag->id);
            } else {
                // 不存在，先创建标签，在更新关系表
                $tag = new Tag;
                $tag->name = $tags[$i];
                $tag->save();
                $article->tags()->attach($tag->id);
            }
        }

        return redirect()->route('articles.show', array('article' => $article->id))->with('success', '文章编辑成功！');
    }
}
