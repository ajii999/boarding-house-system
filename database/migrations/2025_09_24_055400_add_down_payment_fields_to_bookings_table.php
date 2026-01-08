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
            $table->decimal('down_payment_amount', 10, 2)->nullable()->after('total_amount');
            $table->string('down_payment_receipt')->nullable()->after('down_payment_amount');
            $table->date('down_payment_date')->nullable()->after('down_payment_receipt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['down_payment_amount', 'down_payment_receipt', 'down_payment_date']);
        });
    }
};
