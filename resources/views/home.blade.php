@extends('layouts.app')
@section('afterCss')
    <style>
        .panel-heading {
            padding: 10px 15px;
            border: 1px solid transparent;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
        }
        .sidebar ul li {
            list-style: none;
            padding: 10px 15px;
            border-bottom: 1px solid #d3e0e9;
            border-left: 1px solid #d3e0e9;
            border-right: 1px solid #d3e0e9;
        }
        .topic {
            border: 1px solid #d3e0e9;
            background-color: #fff;
            border-radius: 3px;
        }
        .blog-topic {
            padding: 15px;
            border-bottom: 1px solid #d3e0e9;
        }
        .pages {
            padding-left: 15px; !important;
        }
        .carousel-control.left, .carousel-control.right {
            background-image: none;
        }
        #myCarousel {
            margin-bottom: 22px;
            border: 1px solid #d3e0e9;
            border-radius: 3px;
        }
        .carousel-indicators .active {
            width: 40px;
            height: 10px;
        }
        .carousel-indicators li {
            width: 15px;
            height: 10px;
            margin: 0;
            background-color: #fff;
        }
        .blog-order {
            margin-bottom: 22px;
        }
        .blog-order a {
            padding: 7px 22px;
            color: #000;
        }
        .blog-order .active {
            background-color: orange;
            border-radius: 5px;
            color: #fff;
        }
        .hot-red {
            display: inline-block;
            padding: 1px 0;
            color: #fff;
            width: 14px;
            line-height: 100%;
            font-size: 12px;
            text-align: center;
            background-color: red;
            margin-right: 10px;
        }
        .hot-orangered {
            display: inline-block;
            padding: 1px 0;
            color: #fff;
            width: 14px;
            line-height: 100%;
            font-size: 12px;
            text-align: center;
            background-color: orangered;
            margin-right: 10px;
        }
        .hot-orange {
            display: inline-block;
            padding: 1px 0;
            color: #fff;
            width: 14px;
            line-height: 100%;
            font-size: 12px;
            text-align: center;
            background-color: orange;
            margin-right: 10px;
        }
        .hot-default {
            display: inline-block;
            padding: 1px 0;
            color: #fff;
            width: 14px;
            line-height: 100%;
            font-size: 12px;
            text-align: center;
            background-color: #8eb9f5;
            margin-right: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-9 ">
            <div id="myCarousel" class="carousel slide">
                <!-- 轮播（Carousel）指标 -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>
                <!-- 轮播（Carousel）项目 -->
                <div class="carousel-inner">
                    <div class="item active">
                        <img src="/images/3.png" alt="First slide">
                    </div>
                    <div class="item">
                        <img src="/images/2.png" alt="Second slide">
                    </div>
                    <div class="item">
                        <img src="/images/1.png" alt="Third slide">
                    </div>
                </div>
                <!-- 轮播（Carousel）导航 -->
                <a class="carousel-control left" href="#myCarousel"
                   data-slide="prev"> <span _ngcontent-c3="" aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span></a>
                <a class="carousel-control right" href="#myCarousel"
                   data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
            </div>
            <div class="blog-order">
                <a class="{{ active_class(if_query('order', 'default')) }}" href="{{ Request::url() }}?order=default" class="active">最新</a>
                <a class="{{ active_class(if_query('order', 'hot')) }}" href="{{ Request::url() }}?order=hot">热门</a>
                <a class="{{ active_class(if_query('order', 'buzz')) }}" href="{{ Request::url() }}?order=buzz">热评</a>
            </div>
            <div class="topic">
                @if(sizeof($articles))
                    @foreach($articles as $article)
                        <div class="blog-topic">
                            <h2><a href="/articles/{{ $article->id }}">{{ $article->title }}</a></h2>
                            <p>{{ $article->created_at->toFormattedDateString() }} by <a href="#">{{ $article->user->name }}</a></p>
                            <p>{{ str_limit(strip_tags($article->content_html), 100) }}</p>
                            <p>赞 {{ $article->like_count }} | 评论 {{ $article->reply_count }}</p>
                        </div>
                    @endforeach
                @else
                    <span class="text-center" style="display: block; padding: 20px;">暂无文章~</span>
                @endif
                <div class="pages">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default sidebar" style="border: none;">
                <div class="panel-heading">搜索热点</div>
                <ul class="category-list list-unstyled">
                    @foreach($hot_articles as $k => $hot_article)
                        <li>
                            <a href="{{ route('articles.show', array('id' => $hot_article->id)) }}">
                                <span
                                    @if($k == 0) class="hot-red"
                                    @elseif($k == 1) class="hot-orangered"
                                    @elseif($k == 2) class="hot-orange"
                                    @else class="hot-default" @endif
                                >{{ $k + 1 }}</span>{{ $hot_article->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection