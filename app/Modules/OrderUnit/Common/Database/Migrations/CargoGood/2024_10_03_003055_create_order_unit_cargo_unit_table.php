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
        Schema::create('order_unit_cargo_unit', function (Blueprint $table) {

            $table->uuid('order_unit_id')
                ->constrained('order_units')->noActionOnDelete();

            $table->uuid('cargo_unit_id')
                ->constrained('cargo_units')->noActionOnDelete();

            $table->decimal('factor', 10, 2)->default(1);

            $table->primary(['order_unit_id', 'cargo_unit_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_unit_cargo_unit');
    }
};
