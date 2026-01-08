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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id('method_id');
            $table->string('name');
            $table->string('type'); // online, offline, digital_wallet, bank_transfer
            $table->text('description')->nullable();
            $table->json('configuration')->nullable(); // Store method-specific settings
            $table->boolean('is_active')->default(true);
            $table->boolean('requires_verification')->default(false);
            $table->decimal('processing_fee', 8, 2)->default(0);
            $table->integer('processing_time_hours')->default(0); // Hours to process
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
