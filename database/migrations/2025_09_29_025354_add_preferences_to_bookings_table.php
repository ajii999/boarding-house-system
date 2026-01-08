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
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'preferences')) {
                $table->text('preferences')->nullable()->after('total_amount');
            }
            if (!Schema::hasColumn('bookings', 'emergency_contact')) {
                $table->string('emergency_contact')->nullable()->after('preferences');
            }
            if (!Schema::hasColumn('bookings', 'occupancy_type')) {
                $table->enum('occupancy_type', ['single', 'shared'])->default('single')->after('emergency_contact');
            }
            if (!Schema::hasColumn('bookings', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('occupancy_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $columnsToDrop = [];
            $columns = ['preferences', 'emergency_contact', 'occupancy_type', 'admin_notes'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('bookings', $column)) {
                    $columnsToDrop[] = $column;
                }
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
