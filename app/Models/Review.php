<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'review'; // Tên bảng đánh giá
    protected $fillable = ['user_id', 'shop_id', 'content', 'rating', 'img_url', 'likes_count'];

    public function shop()
    {
        return $this->belongsTo(CoffeeShop::class, 'shop_id');
    }
     // Định nghĩa quan hệ với bảng users
     public function user()
     {
         return $this->belongsTo(User::class, 'user_id');
     }
     
}

