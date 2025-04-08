<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id(); // Khóa chính tự tăng

            // Các cột dữ liệu
            $table->string('item_name');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('price');
            
            // Liên kết shop_id từ bảng coffeeshop
            $table->unsignedBigInteger('shop_id');
            $table->foreign('shop_id')->references('id')->on('coffeeshop')->onDelete('cascade');

            $table->string('status')->default('Available');

            // Timestamps: created_at và updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
