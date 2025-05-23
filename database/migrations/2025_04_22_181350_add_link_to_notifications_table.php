<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('notification', function (Blueprint $table) {
            $table->string('link')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('notification', function (Blueprint $table) {
            $table->dropColumn('link');
        });
    }
    
};
