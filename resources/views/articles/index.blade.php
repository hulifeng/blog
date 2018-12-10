@extends('layouts.app')
@section('afterCss')
    <style>
        .table td a {
            padding: 5px;
            border: 1px solid #d3e0e9;
            border-radius: 3px;
            color: #636b6f;
        }
        form {
            display: inline;
        }
    </style>
@endsection
@section('content')
    <div class="page-header" style="border: 1px solid #d3e0e9; background-color: #fff; padding: 15px; border-radius: 4px;">
        <span>文章列表 <small>articles list</small></span>
    </div>
    <div class="panel panel-default" style="padding: 15px;">
            <table class="table table-hover">
                <th>#</th>
                <th>title</th>
                <th>content</th>
                <th>operation</th>
                @foreach($articles as $article)
                    <tr>
                        <td>{{ $article->id }}</td>
                        <td width="30%">{{ $article->title }}</td>
                        <td>{{ str_limit(strip_tags($article->content_html), 60) }}</td>
                        <td>
                            <a href="{{ route('articles.show', array('article' => $article->id)) }}"><span class="glyphicon glyphicon-link"></span></a>
                            <a href="{{ route('articles.top', array('article' => $article->id)) }}"><span class="glyphicon glyphicon-upload"></span></a>
                            <a href="{{ route('articles.edit', array('article' => $article->id)) }}"><span class="glyphicon glyphicon-wrench"></span></a>
                            <a href="{{ route('articles.release', array('article' => $article->id)) }}"><span class="glyphicon glyphicon-send"></span></a>
                            {{--<a href="#"><span class="glyphicon glyphicon-trash"></span></a>--}}
                            <a href="#" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-trash"></span></a>
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title" id="myModal">确认框</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="form-group">
                                                    <label for="message-text" class="control-label">确定要删除文章吗？</label>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">返回</button>
                                            <form action="{{ route('articles.destroy', array('article' => $article->id)) }}" method="post">
                                                <input type="hidden" name="_method" value="DELETE">
                                                {{ csrf_field() }}
                                                <button class="btn btn-primary">确认</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $articles->links() }}
        </div>
@endsection