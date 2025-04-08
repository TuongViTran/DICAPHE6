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
        Schema::create('promotion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained('coffeeshop');
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('discount_percent', 5, 2);
            $table->decimal('discount_amount', 10, 2);
            $table->timestamp('start_date');
            $table->timestamp('end_date')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion');
    }
};
