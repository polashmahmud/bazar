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
        Schema::create('daily_item_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grocery_item_id')->constrained('grocery_items')->cascadeOnDelete();
            $table->date('date');
            $table->decimal('price', 10, 2);
            $table->timestamps();

            // Unique constraint: one price per item per day
            $table->unique(['grocery_item_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_item_prices');
    }
};
