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
        .like {
            padding: 7px 22px;
            background-color: orange;
            border-radius: 3px;
            color: #fff;
        }
        .unlike {
            padding: 7px 22px;
            background-color: #fff;
            border-radius: 3px;
            border: 1px solid #ccc;
            color: #000;
        }
        .article-like a:hover {
            text-decoration: none;
        }
        .article-replies .social-feed-box {
            margin-bottom: 0;
            border-bottom: none;
        }
        .social-feed-box {
            /* padding: 15px; */
            border: 1px solid #e7eaec;
            background: #fff;
            margin-bottom: 15px;
        }
        .article-replies .social-avatar {
            padding: 15px 15px 0 15px;
        }
        .social-avatar span {
            height: 40px;
            width: 40px;
            line-height: 40px;
            margin-right: 10px;
            text-align: center;
            color: #fff;
            background-color: orangered;
        }
        .social-avatar .media-body a {
            font-size: 14px;
            display: block;
        }
        .article-replies .social-body {
            padding: 15px;
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
        @if(is_like($article->id))
            <form action="{{ route('articles.unlike', array('article' => $article->id)) }}" id="article-like" method="post">
                <input type="hidden" name="_method" value="DELETE">
                {{ csrf_field() }}
                <a href="#" class="unlike" onclick="$('#article-like').submit();return false;"><span class="glyphicon glyphicon-thumbs-up" style="margin-right: 10px; text-decoration: none;"></span>取消赞</a>
        @else
            <form action="{{ route('articles.like', array('article' => $article->id)) }}" id="article-like" method="post">
                {{ csrf_field() }}
                <a href="#" class="like" onclick="$('#article-like').submit();return false;"><span class="glyphicon glyphicon-thumbs-up" style="margin-right: 10px; text-decoration: none;"></span>点赞</a>
        @endif
        </form>
    </div>

    <div class="article-replies">
        <div class="row">
            <div class="col-lg-12">
                <h4><span class="glyphicon glyphicon-pencil"></span> <a href="#" data-toggle="modal" data-target="#myModal">评论:</a></h4>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <h4 class="modal-title" id="myModalLabel">留下什么吧..</h4>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('comments.store') }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                                    <div class="form-group">
                                        <label for="content">留言</label>
                                        <textarea class="form-control" id="content" name="content" rows="3" required=""></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">昵称</label>
                                        <input type="text" class="form-control" id="author" name="author" placeholder="请输入昵称">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">邮箱</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="请输入邮箱">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">个人网站</label>
                                        <input type="text" class="form-control" id="website" name="website" placeholder="请输入网站">
                                    </div>
                                    <input type="submit" id="commentFormBtn" style="display:none">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="document.getElementById('commentFormBtn').click()">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach($article->comments as $comment)
                    <div class="social-feed-box">
                    <div class="social-avatar">
                        <a href="" class="pull-left">
                            <span style="background-color: orange; display: inline-block;">{{ strtoupper(substr($comment->author, 0, 1)) }}</span>
                        </a>
                        <div class="media-body">
                            <a href="#">{{ $comment->author }}</a>
                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    <div class="social-body">
                        <p>{{ $comment->content }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('scriptsAfterJs')
    <script>
        var parse = new Parsemd();
        var html = parse.render(document.getElementById("editor").value.replace(/^\s+|\s+$/g, ''));
        document.getElementById("content").innerHTML = html;
    </script>
@endsection