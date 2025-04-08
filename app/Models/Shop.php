<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $table = 'shops'; // Đảm bảo tên bảng đúng
    protected $primaryKey = 'id'; // Định nghĩa khóa chính
    public $timestamps = true; // Nếu bảng không có `created_at` và `updated_at`, đặt thành `false`

    protected $fillable = ['name', 'address', 'owner_id']; // Các cột có thể gán dữ liệu
}

