@extends('layouts.app')
@section('afterCss')
    <style>
        .table td a {
            padding: 5px;
            border: 1px solid #d3e0e9;
            border-radius: 3px;
            color: #636b6f;
        }
    </style>
@endsection
@section('content')
    <div class="container">
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
                            <a href="#"><span class="glyphicon glyphicon-upload"></span></a>
                            <a href="{{ route('articles.edit', array('article' => $article->id)) }}"><span class="glyphicon glyphicon-wrench"></span></a>
                            <a href="#"><span class="glyphicon glyphicon-send"></span></a>
                            <a href="#"><span class="glyphicon glyphicon-trash"></span></a>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $articles->links() }}
        </div>
    </div>
@endsection