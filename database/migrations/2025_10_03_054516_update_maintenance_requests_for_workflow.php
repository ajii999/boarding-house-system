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
        Schema::table('maintenance_requests', function (Blueprint $table) {
            // Check if status column exists before dropping
            if (Schema::hasColumn('maintenance_requests', 'status')) {
                $table->dropColumn('status');
            }
        });
        
        Schema::table('maintenance_requests', function (Blueprint $table) {
            // Add new status column with updated enum values
            if (!Schema::hasColumn('maintenance_requests', 'status')) {
                $table->enum('status', ['pending', 'assigned', 'in_progress', 'completed', 'tenant_confirmed', 'closed', 'cancelled'])->default('pending');
            }
            
            // Add staff assignment (check if it doesn't exist)
            if (!Schema::hasColumn('maintenance_requests', 'assigned_staff_id')) {
                $table->foreignId('assigned_staff_id')->nullable()->constrained('staff', 'staff_id')->onDelete('set null');
            }
            
            // Add file uploads (check if they don't exist)
            if (!Schema::hasColumn('maintenance_requests', 'tenant_photo')) {
                $table->string('tenant_photo')->nullable(); // Photo uploaded by tenant
            }
            if (!Schema::hasColumn('maintenance_requests', 'staff_proof_photo')) {
                $table->string('staff_proof_photo')->nullable(); // Photo uploaded by staff
            }
            if (!Schema::hasColumn('maintenance_requests', 'staff_report')) {
                $table->text('staff_report')->nullable(); // Report from staff
            }
            
            // Add timestamps for workflow (check if they don't exist)
            if (!Schema::hasColumn('maintenance_requests', 'assigned_at')) {
                $table->timestamp('assigned_at')->nullable();
            }
            if (!Schema::hasColumn('maintenance_requests', 'started_at')) {
                $table->timestamp('started_at')->nullable();
            }
            if (!Schema::hasColumn('maintenance_requests', 'completed_at')) {
                $table->timestamp('completed_at')->nullable();
            }
            if (!Schema::hasColumn('maintenance_requests', 'tenant_confirmed_at')) {
                $table->timestamp('tenant_confirmed_at')->nullable();
            }
            if (!Schema::hasColumn('maintenance_requests', 'closed_at')) {
                $table->timestamp('closed_at')->nullable();
            }
            
            // Add admin assignment notes (check if it doesn't exist)
            if (!Schema::hasColumn('maintenance_requests', 'assignment_notes')) {
                $table->text('assignment_notes')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance_requests', function (Blueprint $table) {
            // Drop foreign key if it exists
            if (Schema::hasColumn('maintenance_requests', 'assigned_staff_id')) {
                try {
                    $table->dropForeign(['assigned_staff_id']);
                } catch (\Exception $e) {
                    // Foreign key might not exist, continue
                }
            }
            
            // Drop columns only if they exist
            $columnsToDrop = [];
            $columns = [
                'assigned_staff_id',
                'tenant_photo',
                'staff_proof_photo',
                'staff_report',
                'assigned_at',
                'started_at',
                'completed_at',
                'tenant_confirmed_at',
                'closed_at',
                'assignment_notes'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('maintenance_requests', $column)) {
                    $columnsToDrop[] = $column;
                }
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
        
        Schema::table('maintenance_requests', function (Blueprint $table) {
            // Only add status column if it doesn't exist
            if (!Schema::hasColumn('maintenance_requests', 'status')) {
                $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            }
        });
    }
};