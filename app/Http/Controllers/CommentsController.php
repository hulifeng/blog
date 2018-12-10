<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function store(Request $request, Comment $comment)
    {
        Comment::create($request->all());

        return back()->with('success', '发布评论成功！');
    }
}
