<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coffeeshop extends Model
{
    use HasFactory;

    protected $table = 'coffeeshop';

    // Các trường có thể mass assign
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
    ];

    /**
     * Quan hệ với bảng SocialNetwork
     */
    public function socialNetworks()
    {
        return $this->hasMany(SocialNetwork::class, 'coffeeshop_id');
    }

    // Các quan hệ khác và phương thức bổ sung...
}
