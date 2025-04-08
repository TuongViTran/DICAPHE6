<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coffeeshop', function (Blueprint $table) {
            $table->id();
            $table->string('shop_name');
            $table->string('phone')->nullable();
    
            // 1. Khóa ngoại liên kết với bảng users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    
            $table->text('description')->nullable();
    
            // 2. Khóa ngoại liên kết với bảng addresses
            $table->foreignId('address_id')->constrained('addresses')->onDelete('cascade');
    
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->string('parking')->nullable();
            $table->string('wifi_password')->nullable();
            $table->string('hotline')->nullable();
            $table->float('rating')->default(0);
            $table->decimal('min_price', 10, 2)->nullable();
            $table->decimal('max_price', 10, 2)->nullable();

            // 3. Khóa ngoại liên kết với bảng styles
            $table->foreignId('styles_id')->constrained('styles')->onDelete('cascade');
    
            // 4. Khóa ngoại liên kết với bảng social_network
            $table->foreignId('social_network_id')->constrained('social_network')->onDelete('cascade');
    
            // Ảnh: 1 ảnh bìa và 3 ảnh chi tiết
            $table->text('cover_image', 1000)->nullable();
            $table->text('image_1',225)->nullable();
            $table->text('image_2',225)->nullable();
            $table->text('image_3',225)->nullable();

            $table->timestamps();
        });

        // Tạo bảng likes nếu chưa có
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('coffeeshop_id')->constrained('coffeeshop')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
        Schema::dropIfExists('coffeeshop');
    }
};
