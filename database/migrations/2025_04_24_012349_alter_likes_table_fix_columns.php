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
        Schema::table('likes', function (Blueprint $table) {
            // Nếu bạn muốn đổi từ `coffeeshop_id` sang `review_id`
            $table->dropForeign(['coffeeshop_id']);
            $table->dropColumn('coffeeshop_id');
    
            $table->foreignId('review_id')
                  ->constrained('reviews')
                  ->onDelete('cascade');
            
            $table->unique(['user_id', 'review_id'], 'unique_user_review');
            $table->index(['user_id', 'review_id']);
        });
    }
    
    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->dropForeign(['review_id']);
            $table->dropColumn('review_id');
    
            $table->foreignId('coffeeshop_id')
                  ->constrained('coffeeshop')
                  ->onDelete('cascade');
            
            $table->unique(['user_id', 'coffeeshop_id'], 'unique_user_coffeeshop');
            $table->index(['user_id', 'coffeeshop_id']);
        });
    }
    
};
