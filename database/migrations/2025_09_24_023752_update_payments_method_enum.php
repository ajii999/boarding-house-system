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
        // Clean up any existing temp tables from previous failed migrations
        try {
            \DB::statement('DROP TABLE IF EXISTS __temp__payments');
        } catch (\Exception $e) {
            // Ignore if table doesn't exist or can't be dropped
        }
        
        Schema::table('payments', function (Blueprint $table) {
            // First, we need to modify the column to allow the new enum values
            $table->enum('method', ['cash', 'digital_wallet', 'bank_transfer', 'credit_card', 'online'])->default('cash')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Clean up any existing temp tables from previous failed migrations
        try {
            \DB::statement('DROP TABLE IF EXISTS __temp__payments');
        } catch (\Exception $e) {
            // Ignore if table doesn't exist or can't be dropped
        }
        
        // IMPORTANT: Update data BEFORE changing the schema using raw SQL
        // This bypasses Laravel's query builder which might enforce constraints
        // Update any 'digital_wallet' values to 'online' to avoid constraint violations
        try {
            \DB::statement("UPDATE payments SET method = 'online' WHERE method = 'digital_wallet'");
        } catch (\Exception $e) {
            // Ignore if update fails (table might not exist or column might not exist)
        }
        
        Schema::table('payments', function (Blueprint $table) {
            // Revert to original enum values
            $table->enum('method', ['cash', 'bank_transfer', 'credit_card', 'online'])->default('cash')->change();
        });
    }
};
