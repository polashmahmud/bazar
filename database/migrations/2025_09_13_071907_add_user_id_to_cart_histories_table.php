<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cart_histories', function (Blueprint $table) {
            // Add user_id column as nullable first
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
        });

        // Set user_id for existing cart histories
        // If there are items with associated user_id, use that
        // Otherwise, set to the first user or delete orphaned records
        DB::statement('
            UPDATE cart_histories ch
            LEFT JOIN items i ON ch.item_id = i.id
            SET ch.user_id = COALESCE(i.user_id, (SELECT id FROM users LIMIT 1))
            WHERE ch.user_id IS NULL
        ');

        // Delete any cart histories that still don't have user_id
        DB::statement('DELETE FROM cart_histories WHERE user_id IS NULL');

        Schema::table('cart_histories', function (Blueprint $table) {
            // Now make user_id non-nullable and add foreign key
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'is_done']);
            $table->index(['user_id', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_histories', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id', 'is_done']);
            $table->dropIndex(['user_id', 'month']);
            $table->dropColumn('user_id');
        });
    }
};
