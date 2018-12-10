<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = ['content', 'author', 'email', 'website', 'article_id'];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
