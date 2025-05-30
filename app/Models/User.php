<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * Các thuộc tính có thể gán bằng mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name', 'email', 'password', 'role', 'gender', 'avatar_url','phone',
    ];

    /**
     * Các thuộc tính sẽ bị ẩn khi chuyển thành mảng hoặc JSON.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Kiểu dữ liệu cần cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class); // nhớ use App\Models\Post;
    }
      
  
      // Phương thức để lấy URL của ảnh đại diện
      public function getAvatarUrlAttribute()
      {
          return $this->attributes['avatar_url'] ? asset('storage/' . $this->attributes['avatar_url']) : asset('default-avatar.png');
      }

      public function favoriteShops()
      {
          return $this->belongsToMany(CoffeeShop::class, 'favoriteshop', 'user_id', 'shop_id');
      }

       public function likedReviews()
    {
        return $this->belongsToMany(Review::class, 'likes', 'user_id', 'review_id'); // Chỉ định bảng 'likes'
    }
    public function updateAverageRating()
    {
        $average = $this->reviews()->avg('rating');
    
        $this->reviews_avg_rating = $average ?? 0;
        $this->save();
    }

}