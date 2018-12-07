@extends('layouts.app')

@section('afterCss')
    <style>
        .article-show {
            padding: 15px;
        }
        .article-show-title {
            padding: 20px 45px;
        }
        .article-like {
            background-color: #fff;
            width: 100%;
            padding: 45px;
            border: 1px solid #d3e0e9;
            border-radius: 3px;
            text-align: center;
        }
        .article-like a {
            padding: 7px 22px;
            background-color: orange;
            border-radius: 3px;
            color: #fff;
        }
    </style>
    @include('Smartmd::js-parse')
@endsection

@section('content')
    <div class="panel panel-default article-show">
        <div class="article-show-title">
            <h2>{{ $article->title }}</h2>
            <div class="article-show-time" style="margin-top: 22px; margin-right: 22px; display: inline-block;">
                <span class="pull-left">发布于 {{ $article->created_at->toDateString() }} · 最后访问于 {{ $article->updated_at->diffForHumans() }}</span>
                <div class="clearfix"></div>
            </div>
            <div class="article-show-category" style="margin-right: 22px; display: inline-block;">
                <span class="glyphicon glyphicon-folder-open pull-left" style="margin-right: 10px;"></span> <span class="pull-left">{{ $article->category->name }}</span>
                <div class="clearfix"></div>
            </div>
            <div class="article-show-tag" style="display: inline-block;">
                @if($tags)
                    <span class="glyphicon glyphicon-tag pull-left" style="margin-right: 10px;"></span>
                    @foreach($tags as $tag)
                        <span class="pull-left" style="margin-right: 10px;">{{ $tag }}</span>
                    @endforeach
                    <div class="clearfix"></div>
                @endif
            </div>
            <div class="article-show-view-and-review pull-right" style="margin-top: 22px;">
                查看 {{ $article->view_count }} | 评论 {{ $article->reply_count }}
            </div>
            <hr>
        </div>
        <textarea id="editor" placeholder="请输入正文" style="display: none">
            {{ $article->content_markdown }}
        </textarea>
        <div id="content" class="markdown-body"></div>
    </div>
    <div class="article-like">
        <a href="#"><span class="glyphicon glyphicon-thumbs-up" style="margin-right: 10px;"></span>点赞</a>
    </div>
@endsection

@section('scriptsAfterJs')
    <script>
        var parse = new Parsemd();
        var html = parse.render(document.getElementById("editor").value.replace(/^\s+|\s+$/g, ''));
        document.getElementById("content").innerHTML = html;
    </script>
@endsection