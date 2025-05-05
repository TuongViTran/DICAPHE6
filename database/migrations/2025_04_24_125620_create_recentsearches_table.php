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
        Schema::create('recentsearches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Người dùng (nếu có)
            $table->string('keyword')->nullable();
            $table->unsignedBigInteger('style_id')->nullable();
            $table->decimal('min_price', 10, 2)->nullable();
            $table->decimal('max_price', 10, 2)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->float('distance')->nullable(); // khoảng cách (km)
            $table->integer('result_count')->nullable(); // số kết quả tìm được
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recentsearch');
    }
};