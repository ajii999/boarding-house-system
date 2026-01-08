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
        // Clean up any existing temp tables from previous failed migrations
        try {
            DB::statement('DROP TABLE IF EXISTS __temp__payments');
        } catch (\Exception $e) {
            // Ignore if table doesn't exist or can't be dropped
        }
        
        Schema::table('payments', function (Blueprint $table) {
            // Update the method enum to include e-wallet options
            $table->enum('method', ['cash', 'digital_wallet', 'bank_transfer', 'credit_card', 'online', 'gcash', 'maya'])->default('cash')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Clean up any existing temp tables from previous failed migrations
        try {
            DB::statement('DROP TABLE IF EXISTS __temp__payments');
        } catch (\Exception $e) {
            // Ignore if table doesn't exist
        }
        
        // First, update any 'gcash' or 'maya' values to 'digital_wallet' to avoid constraint violations
        DB::table('payments')
            ->whereIn('method', ['gcash', 'maya'])
            ->update(['method' => 'digital_wallet']);
        
        Schema::table('payments', function (Blueprint $table) {
            // Revert to previous enum values
            $table->enum('method', ['cash', 'digital_wallet', 'bank_transfer', 'credit_card', 'online'])->default('cash')->change();
        });
    }
};
