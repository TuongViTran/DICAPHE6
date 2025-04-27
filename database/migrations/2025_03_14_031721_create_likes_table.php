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
            
            // Khóa ngoại đến bảng reviews
            $table->foreignId('review_id')
                ->constrained('review') // Liên kết đến bảng review
                ->onDelete('cascade');
    
            // Đảm bảo mỗi user chỉ like 1 đánh giá 1 lần
            $table->unique(['user_id', 'review_id'], 'unique_user_review');
    
            // Thêm index tăng hiệu suất truy vấn
            $table->index(['user_id', 'review_id']);
    
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
