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
        Schema::table('tasks', function (Blueprint $table) {
            // Only add title column if it doesn't exist
            if (!Schema::hasColumn('tasks', 'title')) {
                $table->string('title')->after('task_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Only drop title column if it exists
            if (Schema::hasColumn('tasks', 'title')) {
                $table->dropColumn('title');
            }
        });
    }
};