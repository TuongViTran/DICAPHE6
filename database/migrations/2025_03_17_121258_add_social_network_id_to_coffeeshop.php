<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('coffeeshop', function (Blueprint $table) {
            if (!Schema::hasColumn('coffeeshop', 'social_network_id')) {
                $table->bigInteger('social_network_id')->unsigned()->nullable();
                $table->foreign('social_network_id')->references('id')->on('social_network')->onDelete('set null');
            }});
    }

    public function down()
    {
        Schema::table('coffeeshop', function (Blueprint $table) {
            $table->dropForeign(['social_network_id']);
            $table->dropColumn('social_network_id');
        });
    }
};

