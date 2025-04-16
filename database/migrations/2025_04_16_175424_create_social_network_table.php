<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialNetworkTable extends Migration
{
    public function up()
    {
        Schema::create('social_network', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // Tên nền tảng mạng xã hội
            $table->string('url'); // Thêm cột 'url' để lưu trữ liên kết
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('social_network');
    }
}