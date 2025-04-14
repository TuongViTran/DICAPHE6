<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Các thuộc tính có thể gán bằng mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name', 'email', 'password', 'role', 'gender', 'avatar_url',
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
}
