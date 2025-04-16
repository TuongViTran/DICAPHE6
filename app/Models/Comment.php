<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment'; // tên bảng nếu không đúng chuẩn Laravel (bình thường là comments)

    protected $fillable = [
        'user_id',
        'post_id',
        'review_id',
        'content',
        'likes_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}
