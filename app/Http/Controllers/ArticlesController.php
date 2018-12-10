<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;
use NoisyWinds\Smartmd\Markdown;

class ArticlesController extends Controller
{
    // 文章列表
    public function index()
    {
        $articles = Article::where('is_del', '<>', 1)->with('user')->paginate();

        return view('articles.index', compact('articles'));
    }

    // 文章详情
    public function show(Article $article)
    {
        $tags = $article->tags->pluck('name')->toArray();

        $article->increment('view_count');

        return view('articles.show', compact('article', 'tags'));
    }

    // 创建文章
    public function create(Article $article)
    {
        $tag = '';
        return view('articles.create_and_edit', compact('article', 'tag'));
    }

    // 保存草稿
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

        return redirect()->route('home')->with('success', '保存草稿成功！');
    }

    // 编辑文章
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

    // 修改文章
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

    // 删除文章
    public function destroy(Article $article)
    {
        if ($article->is_del) {
            return back()->with('danger', '文章已删除，无需重复操作！');
        } else {
            $article->is_del = 1;
            $article->save();
            return back()->with('success', '删除文章成功！');
        }

    }

    // 文章置顶
    public function top(Article $article)
    {
        if ($article->is_top) {
            return back()->with('danger', '文章已置顶，无需重复操作！');
        } else {
            $article->is_top = 1;
            $article->save();
            return back()->with('success', '文章置顶成功！');
        }
    }

    // 发布文章
    public function release(Article $article)
    {
        if ($article->is_hidden) {
            return back()->with('danger', '文章已发布，无需重复操作！');
        } else {
            $article->is_hidden = 1;
            $article->save();
            return back()->with('success', '文章发布成功！');
        }
    }

    // 点赞
    public function like(Request $request, Article $article)
    {
        $data = [
            'ip' => $request->getClientIp(),
            'article_id' => $article->id,
            'created_at' => now(),
            'updated_at' => now()
        ];
        \DB::table('user_likes')->insert($data);

        $article->increment('like_count');

        return back()->with('success', '点赞成功!');
    }

    // 取消赞
    public function unlike(Request $request, Article $article)
    {
        \DB::table('user_likes')->where('ip', $request->getClientIp())->where('article_id', $article->id)->delete();

        $article->decrement('like_count');

        return back()->with('success', '取消赞成功!');
    }
}
