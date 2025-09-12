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
        Schema::create('cart_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->nullable()->constrained()->nullOnDelete();
            $table->string('cart_id')->unique(); // Unique cart instance ID
            $table->string('name');
            $table->text('image')->nullable();
            $table->decimal('quantity', 8, 2)->default(1);
            $table->string('quantity_unit', 50)->default('পিস');
            $table->decimal('price', 10, 2)->default(0);
            $table->string('month'); // YYYY-MM format
            $table->boolean('is_done')->default(false);
            $table->timestamp('done_at')->nullable();
            $table->timestamps();

            $table->index(['month', 'is_done']);
            $table->index('cart_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_histories');
    }
};
