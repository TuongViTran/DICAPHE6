<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Xóa bảng nếu tồn tại trước khi tạo mới
        Schema::dropIfExists('likes');
    
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
    
            // Khóa ngoại đến bảng users
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            
            // Khóa ngoại đến bảng coffeeshop
            $table->foreignId('coffeeshop_id')
            ->constrained('coffeeshop') // Tên bảng là 'coffeeshop'
            ->onDelete('cascade');
    
            // Đảm bảo mỗi user chỉ like 1 quán 1 lần
            $table->unique(['user_id', 'coffeeshop_id'], 'unique_user_coffeeshop');
    
            // Thêm index tăng hiệu suất truy vấn
            $table->index(['user_id', 'coffeeshop_id']);
    
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
