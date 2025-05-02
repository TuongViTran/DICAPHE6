<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coffeeshop extends Model
{
    use HasFactory;

    // Nếu table không phải số nhiều (coffeeshops) thì thêm:
    protected $table = 'coffeeshop';

    protected $fillable = [
        'shop_name', 
        'phone', 
        'user_id', 
        'description', 
        'address_id',
        'status', 
        'opening_time', 
        'closing_time', 
        'parking',
        'wifi_password', 
        'hotline', 
        'rating', 
        'likes',
        'min_price', 
        'max_price', 
        'styles_id', 
        'cover_image', 
        'image_1', 
        'image_2', 
        'image_3'
        // Thêm các trường khác nếu có!
    ];

    // Quan hệ tới bảng địa chỉ
    public function address() {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }

    // Quan hệ với người dùng
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'shop_id');
    }

    // Quan hệ tới user (chủ quán)
    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Kiểm tra User có like quán chưa 
    public function isLikedByUser ($userId) {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    // Quan hệ với bảng like 
    public function likes()
    {
        return $this->hasMany(Like::class, 'coffeeshop_id');
    }
     
    public function menu()
    {
        return $this->hasMany(Menu::class, 'shop_id', 'id');
    }
    
    // Quan hệ với bảng mạng xã hội (nếu bạn không cần, có thể xóa)
    // public function socialNetworks()
    // {
    //     return $this->hasMany(SocialNetwork::class, 'coffeeshop_id');
    // }
  
    public function style()
    {
        return $this->belongsTo(Style::class, 'styles_id');
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favoriteshop', 'shop_id', 'user_id');
    }
}