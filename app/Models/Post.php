<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Nếu bảng là 'posts' thì có thể không cần dòng này
    protected $table = 'post'; // hoặc 'post' nếu đúng DB bạn dùng

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image_url',
        'likes_count',
        'shares_count',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
?>