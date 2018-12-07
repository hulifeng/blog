@extends('layouts.app')
@section('afterCss')
    @include('Smartmd::head')
    <link rel="stylesheet" href="/css/tagsinput.css">
    <style>
        .form-control {
            box-shadow: none;
            border: none;
            border-radius: 0;
        }
        .article-content input {
            border-bottom: 1px solid #ccd0d2;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        @include('layouts._message')
        <div class="page-header" style="border: 1px solid #d3e0e9; background-color: #fff; padding: 15px; border-radius: 4px;">
            <h4>@if($article->id)编辑文章 <small class="text-muted">edit article</small>@else创建文章 <small class="text-muted">create article</small>@endif<span class="glyphicon glyphicon-hand-down pull-right"></span></h4>
        </div>
        <div class="panel panel-default article-content" style="padding: 15px;">
            @if($article->id)
                <form class="form-horizontal" method="post" action="{{ route('articles.update', array('article' => $article->id)) }}">
                    <input type="hidden" name="_method" value="PUT">
            @else
                <form class="form-horizontal" method="post" action="{{ route('articles.store') }}">
            @endif
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="title" class="col-md-2 control-label">标题</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" value="{{ $article->title }}" name="title" id="title" placeholder="请输入标题">
                    </div>
                </div>
                <div class="tagsinput-primary form-group">
                    <label for="tag" class="col-md-2 control-label">标签</label>
                    <div class="col-md-10">
                        <div class="bootstrap-tagsinput">
                            <input type="text" name="tags" id="tagsinputval" class="tagsinput" data-role="tagsinput" value="{{ $tag }}" class="form-control" placeholder="输入后回车">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="editor" class="col-md-2 control-label">内容</label>
                    <div class="col-md-10">
                        <textarea name="content_markdown" placeholder="请输入正文" style="display: none">{{ $article->content_markdown }}</textarea>
                    </div>
                </div>
                <button class="btn btn-primary pull-right" onclick="getinput();">保存</button>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
@endsection

@section('scriptsAfterJs')
    <script src="/js/tagsinput.js"></script>
    <script>
        var smartmd = new Smartmd();

        if (document.body.clientWidth > 1200) {
            smartmd.toggleSideBySide();
        }
    </script>
@endsection