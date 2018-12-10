<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'content_html', 'content_markdown', 'cover', 'reply_count'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeWithOrder($query, $order)
    {
        switch ($order) {
            case 'hot':
                $query->hot();
            case 'buzz':
                $query->buzz();
                break;
            default:
                $query->recent();
                break;
        }
        $query->with('user');
    }

    public function scopeHot($query)
    {
        return $query->orderBy('view_count', 'desc');
    }

    public function scopeBuzz($query)
    {
        return $query->orderBy('reply_count', 'desc');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
