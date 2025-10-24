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
        Schema::create('grocery_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('grocery_item_id')->constrained()->onDelete('cascade');
            $table->decimal('quantity', 8, 2)->default(1);
            $table->string('unit', 50)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('total_price', 10, 2)->virtualAs('quantity * price');
            $table->boolean('purchased')->default(false);
            $table->date('purchase_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grocery_lists');
    }
};
