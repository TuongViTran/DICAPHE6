<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropSocialNetworkIdFromCoffeeshopTable extends Migration
{
    public function up()
    {
        Schema::table('coffeeshop', function (Blueprint $table) {
            $table->dropColumn('social_network_id'); // Xóa trường social_network_id
        });
    }

    public function down()
    {
        Schema::table('coffeeshop', function (Blueprint $table) {
            $table->unsignedBigInteger('social_network_id')->nullable(); // Thêm lại trường nếu cần
        });
    }
}
