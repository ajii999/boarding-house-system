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
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('method_id')->nullable()->after('booking_id');
            $table->timestamp('reservation_expires_at')->nullable()->after('notes');
            $table->string('verification_code', 10)->nullable()->after('reservation_expires_at');
            
            $table->foreign('method_id')->references('method_id')->on('payment_methods')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['method_id']);
            $table->dropColumn(['method_id', 'reservation_expires_at', 'verification_code']);
        });
    }
};
