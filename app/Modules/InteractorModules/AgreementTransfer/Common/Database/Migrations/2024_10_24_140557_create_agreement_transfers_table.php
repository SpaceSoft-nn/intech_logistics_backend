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
        Schema::create('agreement_transfer', function (Blueprint $table) {
            $table->id('id')->primary();

            $table->uuid('agreement_id')
                ->constrained('agreement_orders')->noActionOnDelete();

            $table->uuid('transfer_id')
                ->constrained('transfers')->noActionOnDelete();

            $table->timestamps();

            // Добавляем составной уникальный ключ на order_unit_id и organization_id
            $table->unique(['agreement_id', 'transfer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreement_transfers');
    }
};
