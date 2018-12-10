<?php

/*
 *  判断当前游客是否点赞
 * */
function is_like($article_id)
{
    $ip = request()->getClientIp();
    $is_like = \DB::table('user_likes')->where('ip', $ip)->where('article_id', $article_id)->first();
    return isset($is_like) ? 1 : 0;
}