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
        Schema::create('organization_order_unit_invoces', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('order_unit_id')
                ->constrained('order_units')->noActionOnDelete();

            $table->uuid('organization_id')
                ->constrained('organizations')->noActionOnDelete();

            $table->uuid('invoice_order_id')->unique()
                ->constrained('invoice_orders')->noActionOnDelete();

            $table->timestamps();

            // Добавляем составной уникальный ключ на order_unit_id и organization_id
            $table->unique(['order_unit_id', 'organization_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_order_unit_invoces');
    }
};
