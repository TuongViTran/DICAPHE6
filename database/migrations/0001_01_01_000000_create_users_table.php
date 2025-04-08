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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // bigint unsigned
            $table->string('full_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable(); // Xác thực email
            $table->string('password');
            $table->enum('role', ['user', 'owner', 'admin'])->default('user'); // Chỉ chấp nhận các giá trị hợp lệ
            $table->string('phone', 15)->nullable();
            $table->string('avatar_url', 255)->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable(); // Cột giới tính
            $table->rememberToken();
            // Thêm cột latitude và longitude
            $table->decimal('latitude', 10, 8)->nullable();  // Vĩ độ
            $table->decimal('longitude', 11, 8)->nullable(); // Kinh độ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
