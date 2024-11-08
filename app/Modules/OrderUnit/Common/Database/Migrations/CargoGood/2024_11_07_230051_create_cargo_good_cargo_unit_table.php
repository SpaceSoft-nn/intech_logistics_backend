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
        Schema::create('cargo_good_cargo_unit', function (Blueprint $table) {

            $table->id('id')->primary();

            $table->uuid('cargo_good_id')
                ->constrained('cargo_goods')->noActionOnDelete();

            $table->uuid('cargo_unit_id')
                ->constrained('cargo_units')->noActionOnDelete();

            $table->decimal('factor', 10, 2)->default(1);

            $table->primary(['order_unit_id', 'cargo_unit_id']);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargo_good_cargo_unit');
    }
};
